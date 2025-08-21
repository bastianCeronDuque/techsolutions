<?php

namespace App\View\Components;

use App\Services\BancoCentralApiService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UfValue extends Component
{
    public ?string $value;

    public function __construct(BancoCentralApiService $bancoCentralApi)
    {
        $this->value = $bancoCentralApi->getUfValue();
    }

    public function render(): View|Closure|string
    {
        return view('components.uf-value');
    }
}