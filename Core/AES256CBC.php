<?php
declare(strict_types = 1);
namespace Klapuch\Encryption;

/**
 * AES-256-CBC cipher
 */
final class AES256CBC extends AES implements Cipher {
	const BEGIN = 0;
	const MAC_LENGTH = 64;
	const COST = 12;
	const ALGORITHM = PASSWORD_DEFAULT;
	const CIPHER = 'AES-256-CBC';

	public function encryption(string $plain): string {
		$iv = $this->iv();
		$cipherText = openssl_encrypt(
			$this->hash($plain),
			self::CIPHER,
			$this->key(),
			OPENSSL_RAW_DATA,
			$iv
		);
		return bin2hex($iv . $cipherText);
	}

	public function decrypted(string $plain, string $hash): bool {
		return password_verify($plain, $this->decryption($hash));
	}

	public function deprecated(string $hash): bool {
		return password_needs_rehash(
			$this->decryption($hash),
			self::ALGORITHM,
			['cost' => self::COST]
		);
	}

	private function iv(): string {
		return random_bytes(openssl_cipher_iv_length(self::CIPHER));
	}

	private function hash(string $plain): string {
		return password_hash(
			$plain,
			self::ALGORITHM,
			['cost' => self::COST]
		);
	}

	private function decryption(string $hash): string {
		$binary = hex2bin($hash);
		$ivSize = openssl_cipher_iv_length(self::CIPHER);
		$iv = substr($binary, self::BEGIN, $ivSize);
		$cipherText = substr(
			substr($binary, $ivSize),
			self::BEGIN,
			self::MAC_LENGTH
		);
		return openssl_decrypt(
			$cipherText,
			self::CIPHER,
			$this->key(),
			OPENSSL_RAW_DATA,
			$iv
		);
	}
}