@extends('layouts.nextwork')

@section('content')
    <div class="flex h-[calc(100vh-4rem)] overflow-hidden bg-white">

        {{-- Conversation List --}}
        <aside class="w-1/3 border-r border-gray-200 overflow-y-auto">
            <div class="p-4 font-semibold text-gray-800 border-b text-lg">Messages</div>
            <ul class="divide-y">
                {{-- Sample Conversations --}}
                @foreach (range(1, 10) as $i)
                    <li class="p-4 hover:bg-gray-50 cursor-pointer flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name=User+{{ $i }}&background=14B8A6&color=fff"
                            alt="" class="h-10 w-10 rounded-full object-cover">
                        <div class="flex-1 min-w-0">
                            <div class="font-medium text-gray-900">User {{ $i }}</div>
                            <div class="text-sm text-gray-500 truncate">Hey there! This is a sample message preview...</div>
                        </div>
                        <div class="text-xs text-gray-400">2m ago</div>
                    </li>
                @endforeach
            </ul>
        </aside>

        {{-- Message Thread --}}
        <section class="flex-1 flex flex-col">
            {{-- Header --}}
            <div class="p-4 border-b flex items-center gap-3">
                <img src="https://ui-avatars.com/api/?name=John+Doe&background=14B8A6&color=fff" alt=""
                    class="h-10 w-10 rounded-full object-cover">
                <div>
                    <div class="font-semibold text-gray-800">John Doe</div>
                    <div class="text-xs text-gray-500">Online</div>
                </div>
            </div>

            {{-- Messages --}}
            <div class="flex-1 p-4 overflow-y-auto space-y-4 bg-gray-50">
                {{-- Incoming message --}}
                <div class="flex items-start gap-2">
                    <img src="https://ui-avatars.com/api/?name=John+Doe" class="h-8 w-8 rounded-full">
                    <div class="bg-white px-4 py-2 rounded-lg shadow-sm text-sm max-w-xs">
                        Hey bro! How’s everything going?
                    </div>
                </div>

                {{-- Outgoing message --}}
                <div class="flex justify-end">
                    <div class="bg-teal-600 text-white px-4 py-2 rounded-lg text-sm shadow max-w-xs">
                        All good here! Just working on the UI.
                    </div>
                </div>
            </div>

            {{-- Message Input --}}
            <form class="border-t p-4 flex gap-2">
                <input type="text" placeholder="Type your message..."
                    class="flex-1 border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                <button type="submit"
                    class="bg-teal-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-teal-700">Send</button>
            </form>
        </section>

    </div>
@endsection
