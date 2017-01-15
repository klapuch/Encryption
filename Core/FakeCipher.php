<?php
declare(strict_types = 1);
namespace Klapuch\Encryption;

final class FakeCipher implements Cipher {
	private $decrypted;
	private $deprecated;
	private $encryption;

	public function __construct(
		bool $decrypted = null,
		bool $deprecated = false,
		string $encryption = 'secret'
	) {
		$this->decrypted = $decrypted;
		$this->deprecated = $deprecated;
		$this->encryption = $encryption;
	}

	public function encryption(string $plain): string {
		return $this->encryption;
	}

    public function decrypted(string $plain, string $encryption): bool {
        if($this->decrypted === null)
            return $plain == $encryption;
        return $this->decrypted;
	}

	public function deprecated(string $encryption): bool {
		return $this->deprecated;
	}
}