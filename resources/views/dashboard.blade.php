@extends('admin.layout.master')


@section('content')
    <div style="height: 100%; display: flex; justify-content: center; align-items: center; flex-direction: column;">
        <h2>Bạn đã đăng nhập với quyền {{$role == 'admin' ? 'Quản trị viên' : 'Nhân viên'}}</h2>
        <h2>Vui lòng chọn các chức năng cần sử dụng</h2>
    </div>

@endsection


{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}