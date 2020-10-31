@extends('layouts.app')

@section('content')
<template>
    <div class="flex-center position-ref full-height">
        <div class="content">
            <favorite-list-component v-bind:current-user='{!! Auth::user()->toJson() !!}'></favorite-list-component>

        </div>
    </div>
</template>
@endsection
