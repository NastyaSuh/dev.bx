<?php
$secret = "Sup3rS3cr3tSr1ng4815162342";

class MySuperDebuggerClass
{
    private $text = "";
    private $file = './var/log/app/applog.txt';
    private $sep = "\n-------------------\n";

    function __construct()
    {
    }

    function addmessagetolog($msg){
        $this->text .= $msg . "\n";
    }

    function __destruct()
    {
        if (strlen($this->text)){
            $a = file_put_contents($this->file, $this->text . $this->sep, FILE_APPEND);
        }
    }
}

$debugger = new MySuperDebuggerClass();

function sqlquery($mysqli, $query)
{
    global $debugger;
    $result = $mysqli->query($query);
    if (!$result) {
        printf($mysqli->error);
        $debugger->addmessagetolog("mysql error: " .$mysqli->error );
        die('');
    }
    return $result;
}

$action = isset($_REQUEST['action']) ? (string)$_REQUEST['action'] : '';
$session = isset($_COOKIE['session']) ? (string)$_COOKIE['session'] : '';
$user = 0;
$is_admin = false;

$mysqli = new mysqli("localhost", "sqluser", "sqlpass", "unsec");
$mysqli->set_charset('utf8');
$mysqli->autocommit(true);

if ($session) {
    try {
        $session = base64_decode($session);
        $session = unserialize($session);

        $id = (int)$session['user'];
        $hash = (string)$session['hash'];
        $is_admin = $session['isadmin'];

        if ($id && $hash) {
            if ($result = sqlquery($mysqli, "SELECT * from users where id=" . $id)) {
                $row = $result->fetch_assoc();
                if ($row && md5((string)$id . $secret) === $hash)
                    $user = $row;
            }
        }
    } catch (Exception $e) {
        $debugger->addmessagetolog('retrieve bad session');
        $user = 0;
    }
}

switch ($action) {
    case '':
        break;
    case 'logout':
        setcookie('session', '');
        header("Location: ./");
        break;
    case 'login':
        $login = (string)$_POST['login'];
        $pass = (string)$_POST['pass'];

        if ($login && $pass && $result = sqlquery($mysqli, "SELECT * from users where login='{$login}'")) {

            if ($row = $result->fetch_assoc()) {
                list($s, $hash) = explode(":", $row['password'], 2);

                if (md5($s . $pass) === $hash) {
                    $session = ['user' => $row['id'], 'hash' => md5($row['id'] . $secret), 'isadmin' => false];
                    setcookie('session', base64_encode(serialize($session)));
                    header("Location: index.php?id={$row['id']}");
                    // header("Location: index.php?id={$row['id']}&page=feed.php");
                    die();
                } else {
                    $debugger->addmessagetolog('retrieve incorrect password');
                    die('incorrect password');
                }
            } else {
                die('no such user');
            }
        }

        break;
    case 'reg':
        $login = (string)$_POST['login'];
        $pass = (string)$_POST['pass'];

        $login = $mysqli->escape_string($login);

        if ($login && $pass && $result = sqlquery($mysqli, "SELECT * from users where login='{$login}'")) {

            if (!$row = $result->fetch_assoc()) {

                $rnd = rand();
                $pass = $rnd . ":" . md5($rnd . $pass);
                $pass = $mysqli->escape_string($pass);

                sqlquery($mysqli, "INSERT INTO users (login, password) VALUES ('{$login}','{$pass}')");
            } else {
                die('login already exist');
            }
        }
        break;
    case 'getbonus':
        if ($user && !(int)$user['bonus_used']) {
            $balance = $user['balance'] + 100;
            sqlquery($mysqli, "UPDATE users SET balance = {$balance} where id=" . $user['id']);
            sqlquery($mysqli, "UPDATE users SET bonus_used=1 where id=" . $user['id']);
            $mysqli->close();
			header("Location: ./");
            die();
        }
        break;
    case 'changepass':

        $id = (int)$_POST['id'];
        $pass = (string)$_POST['pass'];

        $rnd = rand();
        $pass = $rnd . ":" . md5($rnd . $pass);
        $pass = $mysqli->escape_string($pass);
        sqlquery($mysqli, "UPDATE users SET password = '{$pass}' where id = {$id}");
		header("Location: ./");
        die();

        break;
    case 'uploadphoto':
        if ($user && $_FILES['photo']) {
            $uploaddir = './pictures/';
            $uploadfile = $uploaddir . basename($_FILES['photo']['name']);
            $link = "./pictures/" . basename($_FILES['photo']['name']);
            $link = $mysqli->escape_string($link);


            echo '<pre>';
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadfile)) {
                sqlquery($mysqli, "UPDATE users SET photo = '{$link}' where id=" . $user['id']);
            } else {
                echo "Ошибка файловой загрузки!\n";
            }

			header("Location: ./");
            die();
        }
        break;
    case 'sendcr':
        $to = (int)$_POST['to'];
        $sum = (int)$_POST['sum'];

        $res = sqlquery($mysqli, "SELECT balance from users WHERE id={$user['id']}");
        $row = $res->fetch_row();
        $balance = $row[0];

        if ($user && $to > 0 && $to != (int)$user['id'] && $sum <= (int)$balance) {

            sqlquery($mysqli, "UPDATE users SET balance = balance - {$sum} where id=" . $user['id']);
            sqlquery($mysqli, "UPDATE users SET balance = balance + {$sum} where id=" . $to);
            $mysqli->close();

			header("Location: ./");
            die();
        }
        break;
    case 'addmessage':
        $msg = (string)$_POST['msg'];
        $msg = $mysqli->escape_string($msg);

        if ($user && $msg) {

            sqlquery($mysqli, "INSERT into messages (uid, text) VALUES ({$user['id']}, '{$msg}')");

			header("Location: ./");
            die();
        }
        break;
    default:
        $debugger->addmessagetolog('retrieve bad action');
}

if ($mysqli->error) {
    $debugger->addmessagetolog("mysql error: " .$mysqli->error );
    printf("Connect failed: %s\n", $mysqli->error);
    exit();
}

if (!$user) {
    include 'auth.php';
    exit;
}


$page = (string)$_GET['page'];
$id = $_GET['id'];
if ($user && $page && $id) {
    if (file_exists('pages/' . $page)) {

        $messages = sqlquery($mysqli, "SELECT users.login, messages.text from messages JOIN users on messages.uid = users.id where users.id={$id} ORDER BY messages.id DESC");

        $login = sqlquery($mysqli, "SELECT login from users where id=" . (int)$id);
        $login = $login->fetch_row();
        $login = $login ? $login[0] : '';

        include('pages/' . $page);
    } else {
        die('page not found');
    }

} elseif ($user) {
    $users = sqlquery($mysqli, "SELECT * from users where id!=" . $user['id']);
    $messages = sqlquery($mysqli, "SELECT users.id, users.login, messages.text from messages JOIN users on messages.uid = users.id ORDER BY messages.id DESC");

    include 'profile.php';
}

$mysqli->close();

if ($mysqli->error) {
    $debugger->addmessagetolog("mysql error: " .$mysqli->error );
    printf("mysql error: %s\n", $mysqli->error);
    exit();
}

?>