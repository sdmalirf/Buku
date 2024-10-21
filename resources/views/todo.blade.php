@extends('main')
@section("container")

@if (session('success'))
<div id="successMessage" class="z-40 py-5 px-8 text-md bg-green-600 text-white fixed m-4 rounded-full transition-transform duration-500 transform -translate-x-full opacity-100">
    <strong>Berhasil!</strong> Semangat terus nugasnya!😊
    <p>{{ session('success') }}</p>
</div>

<script>
    // Function to animate the message
    function showMessage() {
        const message = document.getElementById('successMessage');
        if (message) {
            // Slide in
            message.classList.remove('-translate-x-full');
            message.classList.add('translate-x-0');

            // Set timeout for the slide out
            setTimeout(() => {
                // Slide out
                message.classList.remove('translate-x-0');
                message.classList.add('-translate-x-full');

                // Remove the element from DOM after fade out
                setTimeout(() => {
                    message.remove();
                }, 200); // Match this timeout with the slide-out duration
            }, 3000); // Time to stay before sliding out
        }
    }

    // Show message on load
    window.onload = showMessage;
</script>
@endif


@if ($errors->any())
<div class="alert alert-success style='position: fixed;
    top: 0;
    left: 0;
    width: 20%;'">
    <strong>Gagal!</strong> Coba cek kembali!
    <p>{{ session('success') }}</p>
</div>
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
</div>
@endif



<section class="w-full h-full overflow-x-hidden relative">
    <div class="w-2/3 mx-auto flex flex-col gap-6 mt-12">
        <span class="flex flex-col gap-2">
            <h1 class="font-bold text-5xl">To Do List</h1>
            <p class="text-xl font-normal text-gray-500">You have {{ count($todos) }} task{{ count($todos) === 1 ? '' : 's' }} to do</p>

        </span>
        <div class="flex w-full justify-between items-center">
            <div class="flex gap-2">
                <form action="{{ url('todo') }}" method="GET" class="relative w-80">
                    <input
                        type="text"
                        name="search"
                        id="searchInput"
                        placeholder="Search tasks or synopses..."
                        class="w-full pl-10 pr-4 py-2 rounded-full border-gray-300 focus:border-gray-500 focus:outline-none border-2"
                        autocomplete="off" />
                    <div id="searchResults" class="absolute w-full bg-white border border-gray-300 rounded-md hidden z-10"></div>
                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5a7 7 0 100 14 7 7 0 000-14zM21 21l-4.35-4.35"></path>
                    </svg>
                </form>
                <a href="{{ url('todo') }}"
                    class="border-2 border-slate-200 text-blue-500 px-6 py-2 rounded-full"
                    role="menuitem">
                    Refresh
                </a>
            </div>


            <button id="openModalBtn" class="bg-blue-400 w-fit px-8 py-3 rounded-full text-white font-medium flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                <span>Add new task</span>
            </button>
        </div>
        <div class="flex gap-4">
            <div class="relative">
                <button id="dropdownFilter" class="border-2 gap-2 w-fit px-4 py-2 rounded-full text-blue-500 font-medium flex items-center">
                    <!-- Sort Icon -->
                    <img src="{{ asset('images/filter.svg') }}" alt="Sort Options" class="w-6 filter text-blue-500" style="filter: invert(43%) sepia(83%) saturate(2656%) hue-rotate(207deg) brightness(94%) contrast(100%);" />
                    <span>Filter</span>
                </button>

                <div id="dropdownMenu" class="hidden absolute top-8 left-4 z-10 mt-2 w-40 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                    <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="dropdownFilter">
                        <a href="{{ url('todo') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                            role="menuitem">
                            Reset
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'done']) }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                            role="menuitem">
                            Tugas Selesai
                        </a>

                        <!-- Filter by Not Done Tasks -->
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'not_done']) }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                            role="menuitem">
                            Tugas Belum Selesai
                        </a>

                        <!-- Reset Filter -->

                    </div>
                </div>
            </div>

            <div class="relative">
                <button id="dropdownSort" class="border-2 gap-2 w-fit px-4 py-2 rounded-full text-blue-500 font-medium flex items-center">
                    <!-- Sort Icon -->
                    <img src="{{ asset('images/sort.svg') }}" alt="Sort Options" class="w-6 filter text-blue-500" style="filter: invert(43%) sepia(83%) saturate(2656%) hue-rotate(207deg) brightness(94%) contrast(100%);" />
                    <span>Sort</span>
                </button>

                <!-- Dropdown menu with date range filter -->
                <div id="dropdownSortMenu" class="hidden absolute top-8 left-4 z-10 mt-2 w-72 p-4 flex flex-col justify-end items-end gap-2 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                    <button id="closeModalBtn" class="text-gray-500 hover:text-gray-700" aria-label="Close Modal">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <form action="{{ url('todo/filter') }}" id="sort" method="GET" class="w-full">
                        @csrf
                        <label for="startDate" class="block text-sm font-medium text-gray-700">Start Date</label>
                        <input
                            type="date"
                            name="startDate"
                            id="startDate"
                            class="w-full px-4 py-4 rounded-xl border-gray-400 focus:border-gray-500 focus:outline-none border-2"
                            required>

                        <label for="endDate" class="block text-sm font-medium text-gray-700 mt-2">End Date</label>
                        <input
                            type="date"
                            name="endDate"
                            id="endDate"
                            class="w-full px-4 py-4 rounded-xl border-gray-400 focus:border-gray-500 focus:outline-none border-2"
                            required>

                        <div class="flex justify-end gap-2 mt-4">
                            <a href="{{ url('todo') }}"
                                class="border-2 border-slate-200 text-blue-500 px-6 py-2 rounded-full"
                                role="menuitem">
                                Reset
                            </a>


                            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-full">
                                Apply Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <ul class="list-group w-full flex flex-col justify-center items-center gap-6 pt-1 pb-8">
            @foreach ($pinnedTodos as $todo)
            <li class="p-6 shadow-md w-full rounded-xl border-l-8 bg-white border-blue-500 flex flex-col gap-6 ">
                <div class="flex gap-3 items-center">
                    <div class="font-semibold flex items-start justify-start text-slate-500">
                        <img src="{{ asset('images/pinned.png') }}" alt="Options" class="w-full ">
                        Pinned
                    </div>
                    @if ($todo->is_done)
                    <div class="text-green-500 font-semibold">
                        Done
                    </div>
                    @else
                    @endif
                </div>
                <div class="flex flex-col gap-1">
                    <div class="flex justify-between w-full relative">
                        <p class="font-semibold text-3xl">{{ $todo->task }}</p>
                        <button id="dropdownButton-{{ $todo->id }}" class="w-fit p-2 rounded-full text-white font-medium flex items-center gap-2">
                            <img src="{{ asset('images/option.png') }}" alt="Options" class="w-full">
                        </button>
                        <div id="dropdownMenu-{{ $todo->id }}" class="hidden absolute right-6 z-10 mt-2 w-40 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                            <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="dropdownButton-{{ $todo->id }}">
                                <a href="javascript:void(0);"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                    role="menuitem"
                                    onclick="openEditModal('{{ $todo->id }}')">
                                    Edit
                                </a>
                                @if ($todo->is_pinned)
                                <form action="{{ route('todo.unpin', $todo->id) }}" method="POST" class="">
                                    @csrf
                                    <button type="submit" class="w-full text-start px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Unpin</button>
                                </form>
                                @else
                                <form action="{{ route('todo.pin', $todo->id) }}" method="POST" class="">
                                    @csrf
                                    <button type="submit" class="w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Pin</button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 font-medium text-slate-600">
                        <p>{{ $todo->author }}</p>
                        <span class="w-1 h-1 rounded-full bg-slate-400"></span>
                        <p>{{ \Carbon\Carbon::parse($todo->penerbit)->locale('id')->isoFormat('D MMMM YYYY') }}</p>
                    </div>
                    <p class="mt-2">{{ $todo->sinopsis }}</p>
                </div>
                <div class="flex gap-3">
                    @if ($todo->is_done)
                    @else
                    <form action="{{ route('todo.done', $todo->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-blue-400 w-fit px-8 py-3 rounded-full text-white font-medium">
                            Mark As Done
                        </button>
                    </form>
                    @endif
                    <div class="border-2 border-slate-400 w-fit px-8 py-3 rounded-full text-blue-400 font-medium">
                        <form action="{{ url('todo', $todo->id) }}" method="POST">
                            @csrf
                            @method("DELETE")
                            <button class="btn btn-danger">Delete Task</button>
                        </form>
                    </div>
                </div>
            </li>
            <!-- Modal Structure for Edit Task -->
            <div id="editTaskModal-{{ $todo->id }}" class="w-full hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center z-50" aria-hidden="true">
                <!-- Modal content for editing -->
                <div class="bg-white rounded-xl w-3/4 px-12 py-8 relative">


                    <div class="w-full justify-between flex">
                        <div class="flex flex-col gap-2">
                            <h2 class="text-4xl font-bold">Edit Task?</h2>
                            <p class="text-xl mb-4">Update the task details below.</p>
                        </div>

                        <!-- Form for editing task -->
                        <form action="{{ url('todo/' . $todo->id) }}" method="POST" class="flex w-1/2 flex-col gap-4">
                            @csrf
                            @method('PUT')
                            <input
                                type="text"
                                name="task"
                                class="w-full px-4 py-4 rounded-xl border-gray-400 focus:border-gray-500 focus:outline-none border-2"
                                placeholder="Your Task"
                                value="{{ $todo->task }}"
                                required>
                            <input
                                type="text"
                                name="author"
                                class="w-full px-4 py-4 rounded-xl border-gray-400 focus:border-gray-500 focus:outline-none border-2"
                                placeholder="Subject or Topic"
                                value="{{ $todo->author }}"
                                required>
                            <input
                                type="date"
                                name="penerbit"
                                class="w-full px-4 py-4 rounded-xl border-gray-400 focus:border-gray-500 focus:outline-none border-2"
                                value="{{ $todo->penerbit }}"
                                required>
                            <textarea
                                name="sinopsis"
                                class="w-full h-56 px-4 py-4 rounded-xl border-gray-400 focus:border-gray-500 focus:outline-none border-2"
                                placeholder="Fill the description"
                                required>{{ $todo->sinopsis }}</textarea>

                            <!-- Submit and Back buttons -->
                            <div class="flex gap-2">
                                <button class="bg-blue-400 w-fit px-12 py-3 rounded-full text-white font-medium" type="submit">Update</button>
                                <button id="closeModalBtnU2" type="button" class="closeEditModalBtnBottom border-2 border-slate-400 w-fit px-8 py-3 rounded-full text-blue-400 font-medium" data-id="{{ $todo->id }}">Back</button>
                            </div>
                        </form>
                    </div>
                    <img src="{{ asset('images/double-star.png') }}" alt="Logo" class="w-1/3 absolute bottom-4 z-40" />
                </div>
            </div>
            @endforeach

            @foreach ($regularTodos as $todo)
            <li class="p-6 shadow-md w-full rounded-xl border-l-8 bg-white border-blue-500 flex flex-col gap-6 ">
                <div class="flex gap-3 items-center">
                    @if ($todo->is_done)
                    <div class="text-green-500 font-semibold">
                        Done
                    </div>
                    @else
                    @endif
                </div>
                <div class="flex flex-col gap-1">
                    <div class="flex justify-between w-full relative">
                        <p class="font-semibold text-3xl">{{ $todo->task }}</p>
                        <button id="dropdownButton-{{ $todo->id }}" class="w-fit p-2 rounded-full text-white font-medium flex items-center gap-2">
                            <img src="{{ asset('images/option.png') }}" alt="Options" class="w-full">
                        </button>
                        <div id="dropdownMenu-{{ $todo->id }}" class="hidden absolute right-6 z-10 mt-2 w-40 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                            <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="dropdownButton-{{ $todo->id }}">
                                <a href="javascript:void(0);"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                    role="menuitem"
                                    onclick="openEditModal('{{ $todo->id }}')">
                                    Edit
                                </a>
                                @if ($todo->is_pinned)
                                <form action="{{ route('todo.unpin', $todo->id) }}" method="POST" class="">
                                    @csrf
                                    <button type="submit" class="w-full text-start px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Unpin</button>
                                </form>
                                @else
                                <form action="{{ route('todo.pin', $todo->id) }}" method="POST" class="">
                                    @csrf
                                    <button type="submit" class="w-full text-start px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Pin</button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 font-medium text-slate-600">
                        <p>{{ $todo->author }}</p>
                        <span class="w-1 h-1 rounded-full bg-slate-400"></span>
                        <p>{{ \Carbon\Carbon::parse($todo->penerbit)->locale('id')->isoFormat('D MMMM YYYY') }}</p>

                    </div>
                    <p class="mt-2">{{ $todo->sinopsis }}</p>
                </div>
                <div class="flex gap-3">
                    @if ($todo->is_done)
                    @else
                    <form action="{{ route('todo.done', $todo->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-blue-400 w-fit px-8 py-3 rounded-full text-white font-medium">
                            Mark As Done
                        </button>
                    </form>
                    @endif
                    <div class="border-2 border-slate-400 w-fit px-8 py-3 rounded-full text-blue-400 font-medium">
                        <form action="{{ url('todo', $todo->id) }}" method="POST">
                            @csrf
                            @method("DELETE")
                            <button class="btn btn-danger">Delete Task</button>
                        </form>
                    </div>
                </div>
            </li>
            <!-- Modal Structure for Edit Task -->
            <div id="editTaskModal-{{ $todo->id }}" class="w-full flex hidden fixed inset-0 bg-gray-800 bg-opacity-50 justify-center items-center z-50" aria-hidden="true">
                <!-- Modal content for editing -->
                <div class="bg-white rounded-xl w-3/4 px-12 py-8 relative">


                    <div class="w-full justify-between flex">
                        <div class="flex flex-col gap-2">
                            <h2 class="text-4xl font-bold">Edit Task?</h2>
                            <p class="text-xl mb-4">Update the task details below.</p>
                        </div>

                        <!-- Form for editing task -->
                        <form action="{{ url('todo/' . $todo->id) }}" method="POST" class="flex w-1/2 flex-col gap-4">
                            @csrf
                            @method('PUT')
                            <input
                                type="text"
                                name="task"
                                class="w-full px-4 py-4 rounded-xl border-gray-400 focus:border-gray-500 focus:outline-none border-2"
                                placeholder="Your Task"
                                value="{{ $todo->task }}"
                                required>
                            <input
                                type="text"
                                name="author"
                                class="w-full px-4 py-4 rounded-xl border-gray-400 focus:border-gray-500 focus:outline-none border-2"
                                placeholder="Subject or Topic"
                                value="{{ $todo->author }}"
                                required>
                            <input
                                type="date"
                                name="penerbit"
                                class="w-full px-4 py-4 rounded-xl border-gray-400 focus:border-gray-500 focus:outline-none border-2"
                                value="{{ $todo->penerbit }}"
                                required>
                            <textarea
                                name="sinopsis"
                                class="w-full h-56 px-4 py-4 rounded-xl border-gray-400 focus:border-gray-500 focus:outline-none border-2"
                                placeholder="Fill the description"
                                required>{{ $todo->sinopsis }}</textarea>

                            <!-- Submit and Back buttons -->
                            <div class="flex gap-2">
                                <button class="bg-blue-400 w-fit px-12 py-3 rounded-full text-white font-medium" type="submit">Update</button>
                                <button id="closeModalBtnU4" type="button" class="closeEditModalBtnBottom border-2 border-slate-400 w-fit px-8 py-3 rounded-full text-blue-400 font-medium" data-id="{{ $todo->id }}">Back</button>
                            </div>
                        </form>
                    </div>
                    <img src="{{ asset('images/double-star.png') }}" alt="Logo" class="w-1/3 absolute bottom-4 z-40" />
                </div>
            </div>
            @endforeach
        </ul>
    </div>


    <!-- Modal Structure -->
    <div id="taskModal" class=" w-full hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center z-50" aria-hidden="true">
        <div class="bg-white rounded-xl w-3/4 px-12 py-8 relative">
            <div class="w-full flex justify-end mb-6">
                <button id="closeModalBtn" class="text-gray-500 hover:text-gray-700" aria-label="Close Modal">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="w-full justify-between flex">
                <div class="flex flex-col gap-2">
                    <h2 class="text-4xl font-bold">New Task?</h2>
                    <p class="text-xl mb-4">Fill in the task details below.</p>
                </div>


                <form action="{{ url('todo') }}" method="POST" class="flex w-1/2 flex-col gap-4">
                    @csrf
                    <input
                        type="text"
                        name="task"
                        class="w-full px-4 py-4 rounded-xl border-gray-400 focus:border-gray-500 focus:outline-none border-2"
                        placeholder="Your Task"
                        required>

                    <input
                        type="text"
                        name="author"
                        class="w-full px-4 py-4 rounded-xl border-gray-400 focus:border-gray-500 focus:outline-none border-2"
                        placeholder="Subject or Topic"
                        required>

                    <input
                        type="date"
                        placeholder="Deadline Task"
                        name="penerbit"
                        class="w-full px-4 py-4 rounded-xl border-gray-400 focus:border-gray-500 focus:outline-none border-2"
                        required>

                    <textarea
                        name="sinopsis"
                        class="w-full h-56 px-4 py-4 rounded-xl border-gray-400 focus:border-gray-500 focus:outline-none border-2"
                        placeholder="Fill the description"
                        required></textarea>

                    <div class="flex gap-2">
                        <button class="bg-blue-400 w-fit px-12 py-3 rounded-full text-white font-medium" type="submit">Create</button>
                        <button type="button" id="closeModalBtnBottom" class="border-2 border-slate-400 w-fit px-8 py-3 rounded-full text-blue-400 font-medium">Back</button>
                    </div>
                </form>
            </div>
            <img src="{{ asset('images/double-star.png') }}" alt="Logo" class="w-1/3 absolute bottom-4 z-40" />
        </div>
    </div>




    <script>
        const modal = document.getElementById('taskModal');
        const openModalBtn = document.getElementById('openModalBtn');
        const closeModalBtns = document.querySelectorAll('#closeModalBtn, #closeModalBtnBottom, #closeModalBtnU1, #closeModalBtnU2, #closeModalBtnU3, #closeModalBtnU4');

        openModalBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
            modal.setAttribute('aria-hidden', 'false');
            openModalBtn.setAttribute('aria-expanded', 'true');
        });

        closeModalBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                modal.classList.add('hidden');
                modal.setAttribute('aria-hidden', 'true');
                openModalBtn.setAttribute('aria-expanded', 'false');
            });
        });

        const closeEditModalBtns = document.querySelectorAll('.closeEditModalBtnBottom');

        closeEditModalBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const todoId = btn.getAttribute('data-id'); // Ambil ID dari atribut data-id
                const editModal = document.getElementById(`editTaskModal-${todoId}`);
                if (editModal) {
                    editModal.classList.add('hidden');
                    editModal.setAttribute('aria-hidden', 'true');
                }
            });
        });

        document.querySelectorAll('[id^="dropdownButton-"]').forEach(button => {
            button.addEventListener('click', function(event) {
                const dropdownMenu = document.getElementById('dropdownMenu-' + this.id.split('-')[1]);
                dropdownMenu.classList.toggle('hidden');

                event.stopPropagation();
            });
        });

        window.addEventListener('click', function(event) {
            document.querySelectorAll('[id^="dropdownMenu-"]:not(.hidden)').forEach(menu => {
                menu.classList.add('hidden');
            });
        });

        document.querySelectorAll('[id^="dropdownFilter"]').forEach(button => {
            window.addEventListener('beforeunload', function() {
                // Atur ulang nilai input saat halaman akan direfresh
                document.querySelectorAll('#dropdownSortMenu input[type="date"]').forEach(input => {
                    input.value = ''; // Atur input tanggal kembali ke kosong
                });

                // Jika Anda menggunakan filter lainnya, reset juga disini
            });

            button.addEventListener('click', function(event) {
                // Tutup dropdown lainnya
                document.querySelectorAll('#dropdownSortMenu:not(.hidden)').forEach(menu => {
                    menu.classList.add('hidden');
                });

                // Buka atau tutup dropdown filter
                const dropdownFilter = document.getElementById('dropdownMenu');
                dropdownFilter.classList.toggle('hidden');

                event.stopPropagation(); // Mencegah penutupan dropdown dari event klik di luar
            });
        });

        document.querySelectorAll('[id^="dropdownSort"]').forEach(button => {


            button.addEventListener('click', function(event) {
                document.querySelectorAll('#dropdownMenu:not(.hidden)').forEach(menu => {
                    menu.classList.add('hidden');
                });

                const dropdownSort = document.getElementById('dropdownSortMenu');
                dropdownSort.classList.toggle('hidden');
                event.stopPropagation(); // Mencegah penutupan dropdown dari event klik di luar
            });
        });

        // Mencegah penutupan dropdown saat mengklik input tanggal
        document.querySelectorAll('#dropdownSortMenu input[type="date"]').forEach(input => {
            input.addEventListener('click', function(event) {
                event.stopPropagation(); // Mencegah penutupan dropdown
            });
        });

        // Tutup dropdown saat submit atau melakukan aksi lain
        document.getElementById('submitButtonId').addEventListener('click', function(event) {
            const dropdownSort = document.getElementById('dropdownSortMenu');
            dropdownSort.classList.add('hidden'); // Menutup dropdown sort saat submit
        });

        // Hapus event listener untuk klik di luar
        // window.addEventListener('click', function(event) {
        //     document.querySelectorAll('#dropdownSortMenu:not(.hidden), #dropdownMenu:not(.hidden)').forEach(menu => {
        //         menu.classList.add('hidden');
        //     });
        // });



        function openEditModal(taskId) {
            console.log("Opening modal for taskId:", taskId);
            const editModal = document.getElementById('editTaskModal-' + taskId);
            if (editModal) {
                editModal.classList.remove('hidden');
                editModal.setAttribute('aria-hidden', 'false');
            } else {
                console.error('Modal with ID editTaskModal-' + taskId + ' not found.');
            }
        }



        document.querySelectorAll('.closeEditModalBtn, .closeEditModalBtnBottom').forEach(button => {
            button.addEventListener('click', function(event) {
                const taskId = this.getAttribute('data-id');
                const editModal = document.getElementById('editTaskModal-' + taskId);
                editModal.classList.add('hidden');
                editModal.setAttribute('aria-hidden', 'true');
            });
        });

        document.getElementById('resetSortButton').addEventListener('click', function() {
            // Redirect to the URL that shows all tasks
            window.location.href = "{{ url('todo') }}"; // Adjust this URL if necessary
        });

        document.getElementById('searchInput').addEventListener('input', function() {
            const query = this.value;
            const resultsContainer = document.getElementById('searchResults');

            if (query.length === 0) {
                resultsContainer.innerHTML = '';
                resultsContainer.classList.add('hidden');
                return;
            }

            fetch(`/todo/search?query=${query}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length === 0) {
                        resultsContainer.innerHTML = '<div>No results found</div>';
                    } else {
                        resultsContainer.innerHTML = data.map(item =>
                            `<div onclick="selectResult('${item.id}')">${item.task} - ${item.sinopsis}</div>`
                        ).join('');
                    }
                    resultsContainer.classList.remove('hidden');
                });
        });

        // Mencegah form submission dan tetap memungkinkan pencarian
        document.getElementById('searchInput').addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault(); // Mencegah form submission
                this.dispatchEvent(new Event('input')); // Trigger input event untuk melakukan pencarian
            }
        });

        // Fungsi untuk memilih hasil pencarian
        function selectResult(id) {
            document.getElementById('searchInput').value = ''; // Clear the input
            document.getElementById('searchResults').innerHTML = '';
            document.getElementById('searchResults').classList.add('hidden');
            window.location.href = `/todo/${id}`; // Redirect to the selected todo's page
        }
    </script>
    <img src="{{ asset('images/bintang.png') }}" alt="Logo" class="w-1/4 absolute -left-32 bottom-11 -z-30" />
    <img src="{{ asset('images/bintang.png') }}" alt="Logo" class="w-1/6 absolute -right-28 top-11 -z-30 -rotate-180" />
</section>

</div>




@endsection