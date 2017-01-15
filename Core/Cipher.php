<?php
declare(strict_types = 1);
namespace Klapuch\Encryption;

interface Cipher {
	/**
	 * Encryption of the given plain text using current cipher
	 * @param string $plain
	 * @return string
	 */
	public function encryption(string $plain): string;

	/**
	 * Checks whether the plain text is the same as the hash
	 * @param string $plain
	 * @param string $hash
	 * @return bool
	 */
	public function decrypted(string $plain, string $hash): bool;

	/**
	 * Is the given hash too old for the cipher and needs to be changed?
	 * @param string $hash
	 * @return bool
	 */
	public function deprecated(string $hash): bool;
}