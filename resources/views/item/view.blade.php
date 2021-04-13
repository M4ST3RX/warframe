@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center mb-3">
            <div class="w-100">
                <div class="circle m-auto bg-black">
                    <img class="" src="/storage/{{ $item->url }}" alt="{{ $item->name }}" data-holder-rendered="true">
                </div>
            </div>
            <div class="w-100 text-center">
                <span class="item-title text-center">{{ $item->name }}</span>
            </div>
        </div>
        <div class="mb-5">
            <quick-search>
            </quick-search>
        </div>
    </div>
    <div class="min-vw-100 bg-dark">
        <div class="px-3 py-2 d-flex">
            <div class="content-header w-100">
                <div class="content-left w-50">
                    <span style="font-size: 1.4rem">Crafting Resources</span>
                    <div class="mt-2 d-flex">
                        @if(count($resources) === 0)
                            <div class="mx-2">No recipe found</div>
                            @auth
                                @if(auth()->user()->admin)
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#addRecipeModal">Add Recipe</button>
                                @endif
                            @endauth
                        @endif
                        @foreach($resources as $resource)
                            <div class="mx-2"><img height="32px" src="/storage/{{ $resource->url }}">{{ $resource->amount }}</div>
                        @endforeach
                    </div>
                </div>
                <div class="content-right w-50">

                </div>
            </div>
        </div>
    </div>

    @auth
        @if(auth()->user()->admin)
            <add-recipe-modal :blueprint="{{ $item->id }}"></add-recipe-modal>
        @endif
    @endauth
@endsection
