@extends('master')

@section('title', 'Vue.js App')

@section('content') 
    <!--- <router-link to="/multitictactoe">Multiplayer TicTacToe</router-link> -->

    <router-view></router-view>
@endsection

@section('pagescript')
<script src="/js/vueappadmin.js"></script>

<!-- <script src="/js/manifest.js"></script>
<script src="/js/vendor.js"></script>
<script src="/js/vueapp.js"></script>
 -->
 @stop  
