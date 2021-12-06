<?php

namespace App\DataGenerator;

/**
 * This class implements "Standards of financial transactions. Two-dimensional barcode symbols for payments by individuals"
 *
 * ГОСТ Р 56042-2014. Стандарты финансовых операций. Двумерные символы штрихового кода для осуществления платежей физических лиц
 */
final class FinancialTransactionsRu
{
	public const FORMAT_IDENTIFIER = 'ST';
	public const FORMAT_VERSION = '0001';
	public const CHARSET_WIN1251 = 1;
	public const CHARSET_UTF8 = 2;
	public const CHARSET_KOI8R = 3;

	// region mandatory fields
	public const FIELD_NAME = 'Name';
	public const FIELD_PERSONAL_ACCOUNT = 'PersonalAcc';
	public const FIELD_BANK_NAME = 'BankName';
	public const FIELD_BIC = 'BIC';
	public const FIELD_CORRESPONDENT_ACCOUNT = 'CorrespAcc';
	// endregion
	//region common fields
	public const FIELD_SUM = 'Sum';
	public const FIELD_PURPOSE = 'Purpose';
	public const FIELD_PAYEE_INN = 'PayeeINN';
	public const FIELD_PAYER_INN = 'PayerINN';
	public const FIELD_DRAWER_STATUS_CODE = 'DrawerStatus';
	public const FIELD_KPP = 'KPP';
	public const FIELD_CBC = 'CBC';
	public const FIELD_OKTMO = 'OKTMO';
	public const FIELD_PAYMENT_REASON_CODE = 'PaytReason';
	public const FIELD_TAX_PERIOD = 'ТaxPeriod';
	public const FIELD_DOCUMENT_NUMBER = 'DocNo';
	public const FIELD_DOCUMENT_DATE = 'DocDate';
	public const FIELD_TAX_PAYMENT_KIND_CODE = 'TaxPaytKind';
	//endregion
	//region additional fields
	public const FIELD_LAST_NAME = 'LastName';
	public const FIELD_FIRST_NAME = 'FirstName';
	public const FIELD_MIDDLE_NAME = 'MiddleName';
	public const FIELD_PAYER_ADDRESS = 'PayerAddress';
	public const FIELD_BUDGET_PERSONAL_ACCOUNT = 'PersonalAccount';
	public const FIELD_DOCUMENT_INDEX = 'DocIdx';
	public const FIELD_PENSION_ACCOUNT = 'PensAcc';
	public const FIELD_CONTRACT = 'Contract';
	public const FIELD_PAYER_PERSONAL_ACCOUNT = 'PersAcc';
	public const FIELD_FLAT = 'Flat';
	public const FIELD_PHONE = 'Phone';
	public const FIELD_PAYER_ID_TYPE = 'PayerIdType';
	public const FIELD_PAYER_ID_NUMBER = 'PayerIdNum';
	public const FIELD_CHILD_FULL_NAME = 'ChildFio';
	public const FIELD_BIRTH_DATE = 'BirthDate';
	public const FIELD_PAYMENT_TERM = 'PaymTerm';
	public const FIELD_PAYMENT_PERIOD = 'PaymPeriod';
	public const FIELD_PAYMENT_CATEGORY = 'Category';
	public const FIELD_SERVICE_NAME = 'ServiceName';
	public const FIELD_COUNTER_ID = 'CounterId';
	public const FIELD_COUNTER_VALUE = 'CounterVal';
	public const FIELD_NOTICE_NUMBER = 'QuittId';
	public const FIELD_NOTICE_DATE = 'QuittDate';
	public const FIELD_INSTITUTE_NUMBER = 'InstNum';
	public const FIELD_CLASS_NUMBER = 'ClassNum';
	public const FIELD_SPECIALIST_FULL_NAME = 'SpecFio';
	public const FIELD_SURCHANGE = 'AddAmount';
	public const FIELD_RULING_NUMBER = 'RuleId';
	public const FIELD_PROCEEDING_NUMBER = 'ExecId';
	public const FIELD_REGISTRATION_PAYMENT_TYPE = 'RegType';
	public const FIELD_UIN = 'UIN';
	public const FIELD_CODE = 'TechCode';
	//endregion

	public const ERROR_CODE_MANDATORY_FIELD_IS_NOT_FILLED = 101;
	public const ERROR_CODE_VALUE_IS_TOO_LONG = 102;
	public const ERROR_CODE_VALUE_INCORRECT_TYPE = 103;

	protected const VALUE_DELIMITER = '=';

	protected $charsetCode;
	protected $fields = [];

	public function __construct()
	{
		$this->charsetCode = self::CHARSET_UTF8;

		$this->fields = [];
	}

	public function setFields(array $fields): self
	{
		$this->fields = $fields;

		return $this;
	}

	public function setField(string $fieldName, string $value): self
	{
		$this->fields[$fieldName] = $value;

		return $this;
	}

	public function addFields(array $fields): self
	{
		$this->fields = array_merge($this->fields, $fields);

		return $this;
	}

	public function setName(string $name): self
	{
		$this->fields[self::FIELD_NAME] = $name;

		return $this;
	}

	public function setPersonalAccount(string $personalAccount): self
	{
		$this->fields[self::FIELD_PERSONAL_ACCOUNT] = $personalAccount;

		return $this;
	}

	public function setBankName(string $bankName): self
	{
		$this->fields[self::FIELD_BANK_NAME] = $bankName;

		return $this;
	}

	public function setBIC(string $bic): self
	{
		$this->fields[self::FIELD_BIC] = $bic;

		return $this;
	}

	public function setCorrespondentAccount(string $correspondentAccount): self
	{
		$this->fields[self::FIELD_CORRESPONDENT_ACCOUNT] = $correspondentAccount;

		return $this;
	}

	public function validate(): \App\Result
	{
		$result = new \App\Result();

		$mandatoryFieldNames = $this->getMandatoryFieldNames();
		foreach ($mandatoryFieldNames as $mandatoryFieldName)
		{
			if (empty($this->fields[$mandatoryFieldName]))
			{
				$result->addError(
					new \Error(
						'Mandatory field ' . $mandatoryFieldName . ' is not filled',
						self::ERROR_CODE_MANDATORY_FIELD_IS_NOT_FILLED,
					)
				);
			}
		}
		foreach ($this->fields as $fieldName => $value)
		{
			if (!$this->isValueTypeValid($value))
			{
				$result->addError(
					new \Error(
						'Incorrect value type ' . $fieldName,
						self::ERROR_CODE_VALUE_INCORRECT_TYPE,
					)
				);
				continue;
			}
			$value = (string)$value;

			$maxFieldLength = $this->getFieldValueMaximumLength($fieldName);
			if ($maxFieldLength > 0 && mb_strlen($value) > $maxFieldLength)
			{
				$result->addError(
					new \Error(
						'The value of ' . $fieldName . ' is too long',
						self::ERROR_CODE_VALUE_IS_TOO_LONG,
					)
				);
			}
		}

		return $result;
	}

	protected function isValueTypeValid($value): bool
	{
		return (is_null($value) || is_string($value) || is_int($value) || is_float($value));
	}

	protected function getMandatoryFieldNames(): array
	{
		return [
			self::FIELD_NAME,
			self::FIELD_PERSONAL_ACCOUNT,
			self::FIELD_BANK_NAME,
			self::FIELD_BIC,
			self::FIELD_CORRESPONDENT_ACCOUNT,
		];
	}

	public function getFieldValueMaximumLength(string $fieldName): ?int
	{
		static $maximumFieldLengths = [
			self::FIELD_NAME => 160,
			self::FIELD_PERSONAL_ACCOUNT => 20,
			self::FIELD_BANK_NAME => 45,
			self::FIELD_BIC => 9,
			self::FIELD_CORRESPONDENT_ACCOUNT => 20,
		];

		return $maximumFieldLengths[$fieldName] ?? null;
	}

	public function getData(): string
	{
		$delimiter = $this->pickupDelimiter();
		$fields = $this->fields;

		$fields = array_filter($fields, static function($value) {
			return (!empty($value) && !is_array($value) && !is_object($value));
		});

		$data =
			self::FORMAT_IDENTIFIER
			. self::FORMAT_VERSION
			. $this->charsetCode
		;

		foreach ($this->getMandatoryFieldNames() as $fieldName)
		{
			$data .= $delimiter . $fieldName . self::VALUE_DELIMITER . ($fields[$fieldName] ?? '');
			unset ($fields[$fieldName]);
		}

		foreach ($fields as $fieldName => $value)
		{
			$data .= $delimiter . $fieldName . self::VALUE_DELIMITER . $value;
		}

		return $data;
	}

	protected function pickupDelimiter(): ?string
	{
		$possibleDelimiters = ['|', '~', '_', '#', '$' , '^', '&', '*', '/', '`', '@', '%'];

		$allValues = implode(' ', $this->fields);
		foreach ($possibleDelimiters as $delimiter)
		{
			if (!mb_strpos($allValues, $delimiter))
			{
				return $delimiter;
			}
		}

		return '|';
	}
}
