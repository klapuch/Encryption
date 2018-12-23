<?php
declare(strict_types = 1);
/**
 * @testCase
 * @phpVersion > 7.1
 */
namespace Klapuch\Encryption\Unit;

use Klapuch\Encryption;
use Tester;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

final class PasswordHash extends Tester\TestCase {
	public function testHashAndRehashCorrect() {
		$passwordHash = new Encryption\PasswordHash();
		Assert::true($passwordHash->decrypted('TEST123', $passwordHash->encryption('TEST123')));
	}

	public function testHashAndRehashInCorrect() {
		$passwordHash = new Encryption\PasswordHash();
		Assert::false($passwordHash->decrypted('TEST123', $passwordHash->encryption('TEST1234')));
	}

	public function testDeprecations() {
		$oldHash1 = '$argon2i$v=19$m=131072,t=4,p=4$czczaHV1SlFEVDRGT2U4TA$p9rJFSUJwHxBIUx+wnhzLertPtW5WJF8kWV/DYU4pzk';
		$newHash1 = '$argon2i$v=19$m=231072,t=4,p=4$czczaHV1SlFEVDRGT2U4TA$p9rJFSUJwHxBIUx+wnhzLertPtW5WJF8kWV/DYU4pzk';
		$newHash2 = '$argon2i$v=19$m=131072,t=5,p=4$czczaHV1SlFEVDRGT2U4TA$p9rJFSUJwHxBIUx+wnhzLertPtW5WJF8kWV/DYU4pzk';
		$newHash3 = '$argon2i$v=19$m=131072,t=4,p=5$czczaHV1SlFEVDRGT2U4TA$p9rJFSUJwHxBIUx+wnhzLertPtW5WJF8kWV/DYU4pzk';
		$passwordHash = new Encryption\PasswordHash();
		Assert::false($passwordHash->deprecated($oldHash1));
		Assert::true($passwordHash->deprecated($newHash1));
		Assert::true($passwordHash->deprecated($newHash2));
		Assert::true($passwordHash->deprecated($newHash3));
		Assert::true($passwordHash->decrypted('TEST123', $oldHash1));
		Assert::false($passwordHash->decrypted('TEST123', $newHash1));
		Assert::false($passwordHash->decrypted('TEST123', $newHash2));
		Assert::false($passwordHash->decrypted('TEST123', $newHash3));
	}
}

(new PasswordHash())->run();