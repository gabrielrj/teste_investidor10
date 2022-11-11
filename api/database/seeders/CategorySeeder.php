<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $categories = [
                'Agronegócio',
                'Arquitetura e Construção',
                'Autos',
                'Beleza e Bem estar',
                'Cidades',
                'Comportamento',
                'Copa do Mundo',
                'Coronavírus',
                'Cultura e lazer',
                'Economia',
                'Educação',
                'Eleições',
                'Esportes',
                'Gastronomia',
                'Meio Ambiente',
                'Mercado financeiro',
                'Mercado imobiliário' ,
                'Tecnologia e inovação',
                'Trabalho e emprego',
                'Turismo',
                'Variedades'
            ];

            foreach ($categories as $category){
                Category::query()->firstOrCreate(['name' => $category], ['name' => $category]);
            }

        }catch (\Exception $exception){
            print_r(__FUNCTION__ . PHP_EOL);
            print_r($exception->getMessage() . PHP_EOL);
        }
    }
}
