<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_the_web_dashboard_is_only_available_in_the_local_environment(): void
    {
        config(['app.env' => 'production']);

        $this->get(route('home'))->assertNotFound();

        config(['app.env' => 'local']);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Panel de Administración - Nutrik')
            ->assertSee(route('usuarios.index'))
            ->assertSee(route('detalle-compras.index'));
    }
}
