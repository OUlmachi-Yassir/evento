<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Notes') }}
        </h2>
    </x-slot>

    <div class="flex flex-wrap justify-center gap-5 mt-5">
    <div
  class="hover:-translate-y-2 group bg-neutral-50 duration-500 w-44 h-44 flex text-neutral-600 flex-col justify-center items-center relative rounded-xl overflow-hidden shadow-md"
>
  <svg
    viewBox="0 0 200 200"
    xmlns="http://www.w3.org/2000/svg"
    class="absolute blur z-10 fill-red-300 duration-500 group-hover:blur-none group-hover:scale-105"
  >
    <path
      transform="translate(100 100)"
      d="M39.5,-49.6C54.8,-43.2,73.2,-36.5,78.2,-24.6C83.2,-12.7,74.8,4.4,69,22.5C63.3,40.6,60.2,59.6,49.1,64.8C38.1,70,19,61.5,0.6,60.7C-17.9,59.9,-35.9,67,-47.2,61.9C-58.6,56.7,-63.4,39.5,-70,22.1C-76.6,4.7,-84.9,-12.8,-81.9,-28.1C-79,-43.3,-64.6,-56.3,-49.1,-62.5C-33.6,-68.8,-16.8,-68.3,-2.3,-65.1C12.1,-61.9,24.2,-55.9,39.5,-49.6Z"
    ></path>
  </svg>

  <div class="z-20 flex flex-col justify-center items-center">
    <span class="font-bold text-6xl ml-2">{{ $userCount }}+</span>
    <p class="font-bold">Users</p>
  </div>
</div>

<!-- //................... -->
<div
  class="hover:-translate-y-2 group bg-neutral-50 duration-500 w-44 h-44 flex text-neutral-600 flex-col justify-center items-center relative rounded-xl overflow-hidden shadow-md"
>
  <svg
    viewBox="0 0 200 200"
    xmlns="http://www.w3.org/2000/svg"
    class="absolute blur z-10 fill-red-300 duration-500 group-hover:blur-none group-hover:scale-105"
  >
    <path
      transform="translate(100 100)"
      d="M39.5,-49.6C54.8,-43.2,73.2,-36.5,78.2,-24.6C83.2,-12.7,74.8,4.4,69,22.5C63.3,40.6,60.2,59.6,49.1,64.8C38.1,70,19,61.5,0.6,60.7C-17.9,59.9,-35.9,67,-47.2,61.9C-58.6,56.7,-63.4,39.5,-70,22.1C-76.6,4.7,-84.9,-12.8,-81.9,-28.1C-79,-43.3,-64.6,-56.3,-49.1,-62.5C-33.6,-68.8,-16.8,-68.3,-2.3,-65.1C12.1,-61.9,24.2,-55.9,39.5,-49.6Z"
    ></path>
  </svg>

  <div class="z-20 flex flex-col justify-center items-center">
    <span class="font-bold text-6xl ml-2">{{ $eventCount }}+</span>
    <p class="font-bold">Events</p>
  </div>
</div>
<!-- ;;;;;;;;;;;;;;;;; -->
<div
  class="hover:-translate-y-2 group bg-neutral-50 duration-500 w-44 h-44 flex text-neutral-600 flex-col justify-center items-center relative rounded-xl overflow-hidden shadow-md"
>
  <svg
    viewBox="0 0 200 200"
    xmlns="http://www.w3.org/2000/svg"
    class="absolute blur z-10 fill-red-300 duration-500 group-hover:blur-none group-hover:scale-105"
  >
    <path
      transform="translate(100 100)"
      d="M39.5,-49.6C54.8,-43.2,73.2,-36.5,78.2,-24.6C83.2,-12.7,74.8,4.4,69,22.5C63.3,40.6,60.2,59.6,49.1,64.8C38.1,70,19,61.5,0.6,60.7C-17.9,59.9,-35.9,67,-47.2,61.9C-58.6,56.7,-63.4,39.5,-70,22.1C-76.6,4.7,-84.9,-12.8,-81.9,-28.1C-79,-43.3,-64.6,-56.3,-49.1,-62.5C-33.6,-68.8,-16.8,-68.3,-2.3,-65.1C12.1,-61.9,24.2,-55.9,39.5,-49.6Z"
    ></path>
  </svg>

  <div class="z-20 flex flex-col justify-center items-center">
    <span class="font-bold text-6xl ml-2">{{$reservationCount }}+</span>
    <p class="font-bold">reservation</p>
  </div>
</div>
     
</div>
    

    <div class="container flex mt-11 flex-wrap justify-center gap-8 items-center">
        <!-- Display Category List -->
        <div class="my-8">
            <h2 class="text-3xl font-semibold mb-6">All Categories</h2>
            <ul>
                @foreach($categories as $category)
                    <li class="flex items-center justify-between py-2 border-b border-gray-300">
                        {{ $category->name }}

                        <!-- Edit Button - Show Edit Form -->
                        <button class="edit-btn text-blue-600 hover:text-blue-800 mr-2" data-category-id="{{ $category->id }}">Edit</button>

                        <!-- Edit Form -->
                        <form data-categoryId="{{ $category->id }}" method="POST" action="{{ route('admin.category.update', $category->id) }}" class="edit-form" style="display: none;">
                            @csrf
                            @method('PUT')
                            <input type="text" name="name" value="{{ $category->name }}" class="border border-gray-300 rounded-lg px-3 py-1 focus:outline-none focus:border-blue-400">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-4 rounded-lg ml-2">Update</button>
                        </form>

                        <!-- Delete Button - Show Delete Form -->
                        <button class="text-red-600 hover:text-red-800 mr-2" type="submit" form="delete-form-{{ $category->id }}">Delete</button>

                        <!-- Delete Form -->
                        <form id="delete-form-{{ $category->id }}" method="POST" action="{{ route('admin.category.destroy', $category->id) }}" style="display: none;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Confirm Delete</button>
                        </form>
                    </li>
                @endforeach
            </ul>
            
        </div>

    

        <!-- Create Category Form -->
    <div class="flex items-center justify-center w-[500px]">
    <div class=" p-8 w-full md:w-2/3 lg:w-1/2">
        <h2 class="text-3xl font-semibold mb-6">Create Category</h2>
        <form method="POST" action="{{ route('admin.category.store') }}" class="space-y-4">
            @csrf
            <div>
                <label for="category-name" class="block text-sm font-medium text-gray-700">Category Name</label>
                <input type="text" name="name" id="category-name" placeholder="Enter category name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Create
                </button>
            </div>
        </form>
    </div>
</div>
<div>
    <h2 class="text-3xl font-semibold mb-6">All Users</h2>
    <ul>
        @foreach($users as $user)
            <li class="flex items-center justify-between py-2 border-b gap-6 border-gray-300">
                <div class="flex gap-6">
                    <span>{{ $user->name }}</span>
                    <span>{{ $user->email }}</span>
                    <span>{{ $user->role }}</span>
                </div>
                <div>
                    <form method="POST" action="{{ route('admin.toggleBan', $user->id) }}">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="text-red-600 hover:text-red-800">
                            {{ $user->ban ? 'Unban' : 'Ban' }}
                        </button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>
</div>



    

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editButtons = document.querySelectorAll('.edit-btn');

            editButtons.forEach(btn => {
                btn.addEventListener('click', function () {
                    const categoryId = btn.getAttribute('data-category-id');
                    const editForm = document.querySelector('.edit-form[data-categoryId="' + categoryId + '"]')

                    // Toggle visibility of edit form
                    if (editForm) {
                        editForm.style.display = (editForm.style.display === 'none') ? 'block' : 'none';
                    }
                });
            });
        });
    </script>
</x-app-layout>
