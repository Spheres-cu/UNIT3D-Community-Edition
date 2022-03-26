<?php

namespace App\Http\Livewire;

use App\Models\Movie;
use App\Models\Person;
use App\Models\Tv;
use Livewire\Component;

class QuickSearchDropdown extends Component
{
    public string $movie = '';

    public string $series = '';

    public string $person = '';

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $search_results = [];

        if (strlen($this->movie) >= 3) {
            $search_results = Movie::query()
                ->select(['id', 'poster', 'title', 'release_date'])
                ->where('title', 'LIKE', '%'.$this->movie.'%')
                ->oldest('title')
                ->take(10)
                ->get();
        }

        if (strlen($this->series) >= 3) {
            $search_results = Tv::query()
                ->select(['id', 'poster', 'name', 'first_air_date'])
                ->where('name', 'LIKE', '%'.$this->series.'%')
                ->oldest('name')
                ->take(10)
                ->get();
        }

        if (strlen($this->person) >= 3) {
            $search_results = Person::query()
                ->select(['id', 'still', 'name'])
                ->whereNotNull('still')
                ->where('name', 'LIKE', '%'.$this->person.'%')
                ->oldest('name')
                ->take(10)
                ->get();
        }

        return \view('livewire.quick-search-dropdown', [
            'search_results' => $search_results,
        ]);
    }
}
