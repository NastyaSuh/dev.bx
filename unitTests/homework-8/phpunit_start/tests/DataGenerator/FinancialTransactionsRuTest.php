<?php
include '../../src/DataGenerator/FinancialTransactionsRu.php';
include '../../src/Result.php';

class FinancialTransactionsRuTest extends \PHPUnit\Framework\TestCase
{
	public function getValidateFailSamples(): array
	{
		return [
			'empty' => [
				[],
			],
			'filled but empty' => [
				[
					'Name' => '',
					'PersonalAcc' => '',
					'BankName' => '',
					'BIC' => '',
					'CorrespAcc' => '',
				]
			],
			'invalid input' => [
				[
					'Name' => 'Nn',
					'PersonalAcc' => true, //valid input type is string not bool
					'BankName' => 'Tinkoff',
					'BIC' => '123456789',
					'CorrespAcc' => '12345678901234567890',
					]
			],
			'invalid parameters` length' => [
				[
					'Name' => 'Nn',
					'PersonalAcc' => '1234567890123456789012', //valid length of this field is less than 20 characters
					'BankName' => 'Tinkoff',
					'BIC' => '123456789',
					'CorrespAcc' => '12345678901234567890',
				]
			],
			'one field is not filled' => [
				[
					'Name' => 'Nn',
					'BankName' => 'Tinkoff',
					// 'PersonalAcc' field is missing
					'BIC' => '123456789',
					'CorrespAcc' => '12345678901234567890',
					]
			],
			'add new fields' => [
				[
					'Name' => [
						'name' => 'nastya',
						'surname' => 'susha'
					],
					'PersonalAcc' => '123456789',
					'BankName' => 'Tinkoff',
					'BIC' => '123456789',
					'CorrespAcc' => '12345678901234567890',
				]
			]
		];
	}



	/**
	 * @dataProvider getValidateFailSamples
	 *
	 * @param array $fields
	 */
	public function testValidateFail(array $fields): void
	{
		$dataGenerator = new \App\DataGenerator\FinancialTransactionsRu();

		$dataGenerator->setFields($fields);

		$result = $dataGenerator->validate();

		static::assertFalse($result->isSuccess());
	}

	public function testThatValidateSuccess(): void
	{
		$dataGenerator = new \App\DataGenerator\FinancialTransactionsRu();

		$dataGenerator->setFields([]);

		$dataGenerator
			->setName('Name')
			->setBIC('BIC')
			->setBankName('BankName')
			->setCorrespondentAccount('CorrespondentAccount')
			->setPersonalAccount('CorrespondentAccount')
		;

		$result = $dataGenerator->validate();

		static::assertTrue($result->isSuccess());
	}

	public function testGetData(): void
	{
		$dataGenerator = new \App\DataGenerator\FinancialTransactionsRu();

		$dataGenerator->setFields([]);

		$data = $dataGenerator->getData();

		static::assertEquals('ST00012|Name=|PersonalAcc=|BankName=|BIC=|CorrespAcc=', $data);
	}
}
