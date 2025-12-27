<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ArtistsToFollow extends Component
{
    public array $artists;

    /** @return void  */
    public function __construct()
    {
        // Ahora es propiedad de la instancia
        $this->artists = [
            ['img' => 'kdot.png', 'name' => 'kdot_draws'],
            ['img' => 'anne.png', 'name' => 'just_anne'],
            ['img' => 'mr-anderson.png', 'name' => 'Mr. Anderson'],
            ['img' => 'amanda.png', 'name' => 'amanda'],
        ];
    }

    public function render(): View|Closure|string
    {
        // Laravel pasará $this->artists automáticamente con el mismo nombre a la vista!
        return view('components.artists-to-follow');
    }
}
