@extends('layouts.app')

@section('content')
<div class="container">
    <tabs>
        <tab name="Warframes" :selected="true">
            <div class="container">
                <div class="row mt-2" style="padding: 0 10px;">
                    @if(count($items["warframe"]) === 0)
                        No content
                    @endif
                    @foreach($items["warframe"] as $index => $item)
                        <div class="col-md-5ths wf-item-card">
                            <div class="card bg-success">
                                <div class="card-top">
                                    @auth
                                        <button data-id="{{ $item->id }}" class="mastered-btn d-none">Mastered</button>
                                    @endauth
                                    <img class="card-img-top" src="storage/{{ $item->url }}" alt="{{ $item->name }}" />
                                </div>
                                <div class="card-body {{ $item->getColor() }}">
                                    <h5 class="card-title">{{ $item->name }}</h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </tab>
        <tab name="Primary">
            <div class="container">
                <div class="row mt-2" style="padding: 0 10px;">
                    @if(count($items["primary"]) === 0)
                        No content
                    @endif
                    @foreach($items["primary"] as $index => $item)
                        <div class="col-md-5ths wf-item-card">
                            <div class="card bg-success">
                                <div class="card-top">
                                    @auth
                                        <button data-id="{{ $item->id }}" class="mastered-btn d-none">Mastered</button>
                                    @endauth
                                    <img class="card-img-top" src="storage/{{ $item->url }}" alt="{{ $item->name }}" />
                                </div>
                                <div class="card-body {{ $item->getColor() }}">
                                    <h5 class="card-title">{{ $item->name }}</h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </tab>
        <tab name="Secondary">
            <div class="container">
                <div class="row mt-2" style="padding: 0 10px;">
                    @if(count($items["secondary"]) === 0)
                        No content
                    @endif
                    @foreach($items["secondary"] as $index => $item)
                        <div class="col-md-5ths wf-item-card">
                            <div class="card bg-success">
                                <div class="card-top">
                                    @auth
                                        <button data-id="{{ $item->id }}" class="mastered-btn d-none">Mastered</button>
                                    @endauth
                                    <img class="card-img-top" src="storage/{{ $item->url }}" alt="{{ $item->name }}" />
                                </div>
                                <div class="card-body {{ $item->getColor() }}">
                                    <h5 class="card-title">{{ $item->name }}</h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </tab>
        <tab name="Melee">
            <div class="container">
                <div class="row mt-2" style="padding: 0 10px;">
                    @if(count($items["melee"]) === 0)
                        No content
                    @endif
                    @foreach($items["melee"] as $index => $item)
                        <div class="col-md-5ths wf-item-card">
                            <div class="card bg-success">
                                <div class="card-top">
                                    @auth
                                        <button data-id="{{ $item->id }}" class="mastered-btn d-none">Mastered</button>
                                    @endauth
                                    <img class="card-img-top" src="storage/{{ $item->url }}" alt="{{ $item->name }}" />
                                </div>
                                <div class="card-body {{ $item->getColor() }}">
                                    <h5 class="card-title">{{ $item->name }}</h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </tab>
        <tab name="Archwing">
            <div class="container">
                <div class="row mt-2" style="padding: 0 10px;">
                    @if(count($items["archwing"]) === 0)
                        No content
                    @endif
                    @foreach($items["archwing"] as $index => $item)
                        <div class="col-md-5ths wf-item-card">
                            <div class="card bg-success">
                                <div class="card-top">
                                    @auth
                                        <button data-id="{{ $item->id }}" class="mastered-btn d-none">Mastered</button>
                                    @endauth
                                    <img class="card-img-top" src="storage/{{ $item->url }}" alt="{{ $item->name }}" />
                                </div>
                                <div class="card-body {{ $item->getColor() }}">
                                    <h5 class="card-title">{{ $item->name }}</h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </tab>
        <tab name="Companions">
            <div class="container">
                <div class="row mt-2" style="padding: 0 10px;">
                    @if(count($items["companion"]) === 0)
                        No content
                    @endif
                    @foreach($items["companion"] as $index => $item)
                        <div class="col-md-5ths wf-item-card">
                            <div class="card bg-success">
                                <div class="card-top">
                                    @auth
                                        <button data-id="{{ $item->id }}" class="mastered-btn d-none">Mastered</button>
                                    @endauth
                                    <img class="card-img-top" src="storage/{{ $item->url }}" alt="{{ $item->name }}" />
                                </div>
                                <div class="card-body {{ $item->getColor() }}">
                                    <h5 class="card-title">{{ $item->name }}</h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </tab>
    </tabs>
</div>
@endsection
