<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Button
{
    public ?string $label = null;

    public ?string $href = null;

    public string $type = 'button';

    public string $variant = 'primary';
}
