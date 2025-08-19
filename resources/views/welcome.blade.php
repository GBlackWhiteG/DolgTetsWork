@extends('layouts.main')
@section('content')
    @if (session('documentId'))
        <div class="w-full bg-red-500 p-2">
            <span class="text-white font-bold">{{ session('documentId') }}</span>
        </div>
    @endif
    <section>
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl">Список заказов</h1>
            <button id="openCreateModalBtn" class="text-white font-bold bg-blue-500 rounded cursor-pointer py-1.5 px-6 mt-2">Создать новый заказ</button>
        </div>
        <div id="ordersList" class="table border border-black mb-6">
            @foreach($orders as $order)
                <div class="table-row border-b border-black transition cursor-pointer hover:bg-gray-200">
                    <span class="table-cell border-r border-black p-2" data-order="{{ $order->id }}">{{ $order->id }}</span>
                    <span class="table-cell border-r border-black p-2" data-order="{{ $order->name }}" >{{ $order->name }}</span>
                    <span
                        class="table-cell w-full border-r border-black p-2" data-order="{{ $order->description }}">{{ Str::limit($order->description, 100) }}</span>
                    <span class="table-cell border-r border-black p-2" data-order="{{ $order->delivery_date }}">{{ DateTime::createFromFormat('Y-m-d', $order->delivery_date)->format('d.m.Y') }}</span>
                    <span class="table-cell p-2" data-order="{{ $order->status }}">{{ $order->status }}</span>
                </div>
            @endforeach
        </div>
        {{ $orders->links() }}
    </section>

    <div id="detailModal" class="hidden w-full h-full justify-center items-center bg-black/50 fixed top-0 left-0">
        <div class="w-full max-w-[750px] rounded bg-white py-6 px-4">
            <div class="flex justify-between mb-6">
                <h2 class="text-2xl">Заказ подробно</h2>
                <button id="closeDetailModalBtn" class="modal-close-btn__wrapper mr-1"><span
                        class="modal-close-btn"></span></button>
            </div>
            <form action="{{ route('update') }}" method="POST" class="flex flex-col gap-3">
                @csrf
                @method('PATCH')
                <input type="hidden" name="update_order_id">
                <label class="flex flex-col gap-2">
                    <span>Название:</span>
                    <input type="text" name="name" class="border border-black p-2 rounded">
                </label>
                <label class="flex flex-col gap-2">
                    <span>Описание:</span>
                    <textarea name="description" class="border border-black p-2 rounded" rows="6"></textarea>
                </label>
                <label class="flex flex-col gap-2">
                    <span>Дата доставки:</span>
                    <input type="date" min="{{ date('Y-m-d') }}" name="delivery_date"
                           class="border border-black p-2 rounded">
                </label>
                <label class="flex flex-col gap-2">
                    <span>Статус:</span>
                    <select name="status" class="border border-black p-2 rounded">
                        <option value="Allowed">Подтвердить</option>
                        <option value="Prohibited">Отклонить</option>
                    </select>
                </label>
                <button type="submit"
                        class="w-full text-white font-bold bg-blue-500 rounded cursor-pointer py-2 mx-auto mt-2">
                    Сохранить
                </button>
            </form>
            <form action="{{ route('delete') }}" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" name="delete_order_id">
                <button
                    class="w-full text-white font-bold bg-red-500 rounded cursor-pointer py-2 mx-auto mt-2"
                    type="submit">Удалить
                </button>
            </form>
        </div>
    </div>

    <div id="createModal" class="hidden w-full h-full justify-center items-center bg-black/50 fixed top-0 left-0">
        <div class="w-full max-w-[750px] rounded bg-white py-6 px-4">
            <div class="flex justify-between mb-6">
                <h2 class="text-2xl">Создать новый заказ</h2>
                <button id="closeCreateModalBtn" class="modal-close-btn__wrapper mr-1"><span
                        class="modal-close-btn"></span></button>
            </div>
            <form action="{{ route('store') }}" method="POST" class="flex flex-col gap-3">
                @csrf
                <label class="flex flex-col gap-2">
                    <span>Название:</span>
                    <input type="text" name="name" class="border border-black p-2 rounded">
                </label>
                <label class="flex flex-col gap-2">
                    <span>Описание:</span>
                    <textarea name="description" class="border border-black p-2 rounded" rows="6"></textarea>
                </label>
                <label class="flex flex-col gap-2">
                    <span>Дата доставки:</span>
                    <input type="date" min="{{ date('Y-m-d') }}" name="delivery_date"
                           class="border border-black p-2 rounded">
                </label>
                <label class="flex flex-col gap-2">
                    <span>Статус:</span>
                    <select name="status" class="border border-black p-2 rounded">
                        <option value="Allowed">Подтвердить</option>
                        <option value="Prohibited">Отклонить</option>
                    </select>
                </label>
                <button type="submit"
                        class="w-full text-white font-bold bg-blue-500 rounded cursor-pointer py-2 mx-auto mt-2">
                    Создать
                </button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="js/detail-modal.js"></script>
    <script src="js/create-modal.js"></script>
@endsection
