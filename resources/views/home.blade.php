@extends('layouts.app')

@section('content')
<template>

    <div class="flex-center position-ref full-height">
        <div class="content">

            <metro-list-component v-bind:current-user='{!! Auth::user()->toJson() !!}'></metro-list-component>
        </div>
    </div>
</template>
@endsection
