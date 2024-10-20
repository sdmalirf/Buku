@extends('main')
@section("container")


@if (session('success'))
<div class="alert alert-success" style="position: fixed;
    top: 0;
    left: 0;
    width: 20%;">
    <strong>Berhasi!</strong> Data kamu telah ditambahkan.
    <p>{{ session('success') }}</p>
</div>
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
            <div class="relative w-80">
                <input type="text" class="w-full pl-10 pr-4 py-2 rounded-full border-gray-300 focus:border-gray-500 focus:outline-none border-2" />
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5a7 7 0 100 14 7 7 0 000-14zM21 21l-4.35-4.35"></path>
                </svg>
            </div>
            <button id="openModalBtn" class="bg-blue-400 w-fit px-8 py-3 rounded-full text-white font-medium flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                <span>Add new task</span>
            </button>
        </div>

        <ul class="list-group w-full flex flex-col justify-center items-center gap-6 pt-1 pb-8">
            @foreach ($todos as $todo)
            <li class="p-6 shadow-md w-full rounded-xl border-l-8 bg-white border-blue-500 flex flex-col gap-6 ">
                <div class="flex gap-3 items-center">
                    <div class="font-semibold flex items-start justify-start text-slate-500">
                        <img src="{{ asset('images/pinned.png') }}" alt="Options" class="w-full ">
                        Pinned
                    </div>
                    <div class=" text-green-500 font-semibold">
                        Done
                    </div>
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
                                <a href="{{ url('todo/' . $todo->id . '/pin') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Pin</a> <!-- Pin Option -->
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 font-medium text-slate-600">
                        <p>{{ $todo->author }}</p>
                        <span class="w-1 h-1 rounded-full bg-slate-400"></span>
                        <p>{{ $todo->penerbit }}</p>
                    </div>
                    <p class="mt-2">{{ $todo->sinopsis }}</p>
                </div>
                <div class="flex gap-3">
                    <button class="bg-blue-400 w-fit px-8 py-3 rounded-full text-white font-medium">
                        <a href="" class="">Mark As Done</a>
                    </button>
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
                    <div class="w-full flex justify-end mb-6">
                        <!-- Button to close the modal -->
                        <button class="closeEditModalBtn text-gray-500 hover:text-gray-700" aria-label="Close Modal" data-id="{{ $todo->id }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

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
                                type="text"
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
                                <button type="button" class="closeEditModalBtnBottom border-2 border-slate-400 w-fit px-8 py-3 rounded-full text-blue-400 font-medium" data-id="{{ $todo->id }}">Back</button>
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


                <!-- The form inside the modal -->
                <form action="{{ url('todo') }}" method="POST" class="flex w-1/2 flex-col gap-4">
                    @csrf
                    <!-- Task input -->
                    <input
                        type="text"
                        name="task"
                        class="w-full px-4 py-4 rounded-xl border-gray-400 focus:border-gray-500 focus:outline-none border-2"
                        placeholder="Your Task"
                        required>

                    <!-- Subject or Topic input -->
                    <input
                        type="text"
                        name="author"
                        class="w-full px-4 py-4 rounded-xl border-gray-400 focus:border-gray-500 focus:outline-none border-2"
                        placeholder="Subject or Topic"
                        required>

                    <!-- Due Date input -->
                    <input
                        type="text"
                        placeholder="Deadline Task"
                        name="penerbit"
                        class="w-full px-4 py-4 rounded-xl border-gray-400 focus:border-gray-500 focus:outline-none border-2"
                        required>

                    <!-- Description input (textarea) -->
                    <textarea
                        name="sinopsis"
                        class="w-full h-56 px-4 py-4 rounded-xl border-gray-400 focus:border-gray-500 focus:outline-none border-2"
                        placeholder="Fill the description"
                        required></textarea>

                    <!-- Submit and Back buttons -->
                    <div class="flex gap-2">
                        <button class="bg-blue-400 w-fit px-12 py-3 rounded-full text-white font-medium" type="submit">Create</button>
                        <button type="button" id="closeModalBtnBottom" class="border-2 border-slate-400 w-fit px-8 py-3 rounded-full text-blue-400 font-medium">Back</button>
                    </div>
                </form>
            </div>
            <img src="{{ asset('images/double-star.png') }}" alt="Logo" class="w-1/3 absolute bottom-4 z-40" />
        </div>
    </div>




    <!-- JavaScript to toggle the modal -->
    <script>
        // Get the modal, buttons, and close functionality
        const modal = document.getElementById('taskModal');
        const openModalBtn = document.getElementById('openModalBtn');
        const closeModalBtns = document.querySelectorAll('#closeModalBtn, #closeModalBtnBottom');

        // Function to show the modal
        openModalBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
            modal.setAttribute('aria-hidden', 'false');
            openModalBtn.setAttribute('aria-expanded', 'true');
        });

        // Function to hide the modal
        closeModalBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                modal.classList.add('hidden');
                modal.setAttribute('aria-hidden', 'true');
                openModalBtn.setAttribute('aria-expanded', 'false');
            });
        });

        // Dropdown functionality
        document.querySelectorAll('[id^="dropdownButton-"]').forEach(button => {
            button.addEventListener('click', function(event) {
                const dropdownMenu = document.getElementById('dropdownMenu-' + this.id.split('-')[1]);
                dropdownMenu.classList.toggle('hidden');
                // Menghentikan event bubbling agar klik pada dropdown tidak menutupnya
                event.stopPropagation();
            });
        });

        // Close dropdown when clicking outside
        window.addEventListener('click', function(event) {
            // Sembunyikan semua dropdown menu yang terlihat
            document.querySelectorAll('[id^="dropdownMenu-"]:not(.hidden)').forEach(menu => {
                menu.classList.add('hidden');
            });
        });

        // Function to open the specific modal for each task
        // Event listener untuk membuka modal edit berdasarkan ID task yang di-klik
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



        // Event listener untuk menutup modal edit
        document.querySelectorAll('.closeEditModalBtn, .closeEditModalBtnBottom').forEach(button => {
            button.addEventListener('click', function(event) {
                const taskId = this.getAttribute('data-id');
                const editModal = document.getElementById('editTaskModal-' + taskId);
                editModal.classList.add('hidden');
                editModal.setAttribute('aria-hidden', 'true');
            });
        });
    </script>
    <img src="{{ asset('images/bintang.png') }}" alt="Logo" class="w-1/4 absolute -left-32 bottom-11 -z-30" />
    <img src="{{ asset('images/bintang.png') }}" alt="Logo" class="w-1/6 absolute -right-28 top-11 -z-30 -rotate-180" />
</section>

<!-- <div>
<div class="card">
    <div class="card-header" style="background-color: #C8C6C6; font-family:Arial;">Daftar Buku</div>
    <div class="card-body">
        <a href="{{ url('/todo/create') }}" class="btn btn-success btn-sm" title="Add New Contact" style="margin-bottom: 10px;">
            <i class="fa fa-plus" aria-hidden="true"></i> Tambah
        </a>

        <ul class="list-group">
            @foreach ($todos as $todo)
            <li class="list-group-item" style="margin-bottom: 20px; border:2px solid black; border-radius:10px;">
                <p style="text-align:center; font-size:20px; font-family:arial; font-weight:5px;">{{ $todo->task }}</p>
                <div class="row">
                    <div class="col">
                        <a href="{{ url('/todo/' . $todo->id) }}" class="btn btn-info">Detail</a>
                    </div>
                    <div class="col">
                        <a href="todo/{{ $todo->id }}/edit" class="btn btn-warning">Ubah</a>
                    </div>
                    <div class="col">
                        <form action="{{ url('todo',$todo->id) }}" method="POST">
                            @csrf
                            @method("Delete")
                            <button class="btn btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</div> -->
</div>




@endsection