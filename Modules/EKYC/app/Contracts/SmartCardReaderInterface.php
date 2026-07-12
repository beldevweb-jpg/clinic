<?php

namespace Modules\EKYC\Contracts;

use Modules\EKYC\DTO\CardData;

interface SmartCardReaderInterface
{
    public function read(): ?CardData;

    public function connected(): bool;
}
