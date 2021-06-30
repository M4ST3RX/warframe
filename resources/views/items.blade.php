@extends('layouts.app')

@section('content')
<div class="main-container">
    <div class="row">
        <div class="col-md-2">
            <item-filter></item-filter>
        </div>
        <div class="col-md-10">
            <tabs>
                <tab name="Warframe" :selected="true" v-bind:is-logged-in="{{ Auth::check() ? 1 : 0 }}"></tab>
                <tab name="Primary" v-bind:is-logged-in="{{ Auth::check() ? 1 : 0 }}"></tab>
                <tab name="Secondary" v-bind:is-logged-in="{{ Auth::check() ? 1 : 0 }}"></tab>
                <tab name="Melee" v-bind:is-logged-in="{{ Auth::check() ? 1 : 0 }}"></tab>
                <tab name="Archwing" v-bind:is-logged-in="{{ Auth::check() ? 1 : 0 }}"></tab>
                <tab name="Companion" v-bind:is-logged-in="{{ Auth::check() ? 1 : 0 }}"></tab>
            </tabs>
        </div>
    </div>
</div>
@endsection
