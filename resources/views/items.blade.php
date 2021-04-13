@extends('layouts.app')

@section('content')
<div class="container">
    <tabs>
        <tab name="Warframes" :selected="true">
            <div class="container">
                <div class="row mt-2" style="padding: 0 10px;">
                    @if(count($items["warframes"]) === 0)
                        No content
                    @endif
                    @foreach($items["warframes"] as $index => $item)
                        <div class="col-md-5ths wf-item-card">
                            <div class="card bg-success">
                                <div class="card-top">
                                    <button data-id="{{ $item->id }}" class="mastered-btn d-none">Mastered</button>
                                    <img class="card-img-top" src="storage/{{ $item->url }}" alt="{{ $item->name }}" />
                                </div>
                                <div class="card-body @if($item->mastered()) bg-green @else bg-red @endif">
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
                                    <button data-id="{{ $item->id }}" class="mastered-btn d-none">Mastered</button>
                                    <img class="card-img-top" src="storage/{{ $item->url }}" alt="{{ $item->name }}" />
                                </div>
                                <div class="card-body @if($item->mastered()) bg-green @else bg-red @endif">
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
                                    <button data-id="{{ $item->id }}" class="mastered-btn d-none">Mastered</button>
                                    <img class="card-img-top" src="storage/{{ $item->url }}" alt="{{ $item->name }}" />
                                </div>
                                <div class="card-body @if($item->mastered()) bg-green @else bg-red @endif">
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
                                    <button data-id="{{ $item->id }}" class="mastered-btn d-none">Mastered</button>
                                    <img class="card-img-top" src="storage/{{ $item->url }}" alt="{{ $item->name }}" />
                                </div>
                                <div class="card-body @if($item->mastered()) bg-green @else bg-red @endif">
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
