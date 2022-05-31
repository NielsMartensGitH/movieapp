<x-home-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Random Movies') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="container">
                        <div class="row">
                            @foreach($movies_array as $movie)
                            <div class="col col-sm-6">
                                <div class="card h-100">
                                    <div class="card-body flex">
                                        <div class="mx-3">
                                            @if ($movie->Poster == 'N/A')
                                                <img src="{{ asset('storage/no-poster-available.jpg')}}" width="250">
                                            @else
                                                <img src="{{$movie->Poster}}" width="250">
                                            @endif
                                        </div>
                                        <div class="d-flex justify-content-between w-100 align-items-start">
                                            <div>
                                                <h1 class="card-title">{{$movie->Title}}<span> ({{$movie->Year}})</span></h1>
                                                <small>{{$movie->Plot}}</small>
                                            </div>
                                        </div>
                                        </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-home-layout>
