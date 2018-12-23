<?php
declare(strict_types = 1);
namespace Klapuch\Encryption;

/**
 * hash used for password
 */
final class PasswordHash implements Cipher {
	private const ALGORITHM = PASSWORD_ARGON2I;
	private const OPTIONS = [
		'memory_cost' => 128 * 1024,
		'time_cost' => 4,
		'threads' => 4,
	];

	public function encryption(string $plain): string {
		return password_hash($plain, self::ALGORITHM, self::OPTIONS);
	}

	public function decrypted(string $plain, string $hash): bool {
		return password_verify($plain, $hash);
	}

	public function deprecated(string $hash): bool {
		return password_needs_rehash($hash, self::ALGORITHM, self::OPTIONS);
	}
}