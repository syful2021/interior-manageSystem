<div class="pt-5" x-data="modal">
    {{-- Insert Button --}}
    <div class="mb-3">
        <button @click="toggle; $wire.call('showModal')"
            class="bg-blue-500 btn text-white border-0 flex items-center justify-between">
            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Add Department
        </button>
    </div>

    <div class="bg-white dark:bg-slate-900 shadow-md rounded px-4 md:px-8 pt-6 pb-8 mb-4 w-full">
        <h2 class="mb-2 font-bold text-3xl dark:text-white text-blue-500">Department</h2>
        <hr>
        <div>
            {{-- Show Data --}}
            <div class="overflow-auto">
                <table class="w-full">
                    <thead>
                        <tr>
                            <th class="p-3 bg-gray-100 dark:bg-gray-800 text-center">SL</th>
                            <th class="p-3 bg-gray-100 dark:bg-gray-800 text-center">Name</th>
                            <th class="p-3 bg-gray-100 dark:bg-gray-800 text-center">Fee</th>
                            <th class="p-3 bg-gray-100 dark:bg-gray-800 text-center">Duration</th>
                            <th class="p-3 bg-gray-100 dark:bg-gray-800 text-center">Courses</th>
                            <th class="p-3 bg-gray-100 dark:bg-gray-800 text-center">Image</th>
                            <th class="p-3 bg-gray-100 dark:bg-gray-800 text-center">Action</th>
                            <th class="p-3 bg-gray-100 dark:bg-gray-800 text-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($department as $key => $data)
                            <tr>
                                <td class="p-3 border-b border-[#ebedf2] dark:border-[#191e3a] text-center">
                                    {{ $department->firstItem() + $key }} </td>
                                <td class="p-3 border-b border-[#ebedf2] dark:border-[#191e3a] text-center">
                                    {{ $data->name }}
                                </td>
                                <td class="p-3 border-b border-[#ebedf2] dark:border-[#191e3a] text-center">
                                    {{ $data->fee }}
                                </td>
                                <td class="p-3 border-b border-[#ebedf2] dark:border-[#191e3a] text-center">
                                    {{ $data->duration }}
                                </td>
                                <td class="p-3 border-b border-[#ebedf2] dark:border-[#191e3a] text-center">
                                    @foreach ($data->courses as $item)
                                        <span class="block my-1">{{ $item->name }}</span>
                                    @endforeach
                                </td>
                                <td class="p-3 border-b border-[#ebedf2] dark:border-[#191e3a] text-center h-14 w-14">
                                    <img class="shadow-[0_0_15px_1px_rgba(113,106,202,0.30)] dark:shadow-none"
                                        src="{{ asset('storage/' . $data->image) }}" alt="img" width="120" height="100" />
                                </td>
                                <td class="p-3 border-b border-[#ebedf2] dark:border-[#191e3a] text-center">

                                    {{-- Edit Button --}}
                                    <button type="button" x-tooltip="Edit"
                                        @click="open = true; $wire.call('ShowUpdateModel','{{ $data->id }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-pencil text-green-500">
                                            <path class="text-green-500" stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                                            <path d="M13.5 6.5l4 4" />
                                        </svg>
                                    </button>

                                    {{-- Delete Button --}}
                                    <button wire:click="deleteAlert({{ $data->id }})" type="button" x-tooltip="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-trash text-red-500">
                                            <path class="text-red-500" stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M4 7l16 0" />
                                            <path class="text-red-500" d="M10 11l0 6" />
                                            <path class="text-red-500" d="M14 11l0 6" />
                                            <path class="text-red-500" d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                            <path class="text-red-500" d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                        </svg>
                                    </button>
                                </td>
                                <td class="p-3 border-b border-[#ebedf2] dark:border-[#191e3a] text-center">
                                    {{-- Add Course --}}
                                    <button wire:click="singleDepartment({{ $data->id }})" class="bg-blue-500 btn text-white border-0 flex items-center justify-between">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                                            <line x1="12" y1="5" x2="12" y2="19"></line>
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                        </svg>
                                        <span class="text-nowrap">Add Courses</span>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="20">
                                    <div class="flex justify-center items-center">
                                        <img src="{{ asset('empty.png') }}" alt="" class="w-[200px] opacity-40 dark:opacity-15 mt-10 select-none">
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="livewire-pagination mt-5">{{ $department->links() }}</div>
        </div>
    </div>

    {{-- Update & Instert Form --}}
    <div class="fixed inset-0 bg-[black]/60 z-[999] hidden overflow-y-auto" :class="open && '!block'">
        <div class="flex items-center justify-center min-h-screen px-4" @click.self="open = false">
            <div x-show="open" x-transition x-transition.duration.400
                class="panel border-0 p-0 rounded-lg overflow-hidden w-full max-w-lg my-8">
                <div class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-5 py-3">
                    @if (!empty($update_id))
                        <h5 class="font-bold text-lg text-blue-500">Update</h5>
                    @else
                        <h5 class="font-bold text-lg text-blue-500">Add Department</h5>
                    @endif
                </div>
                <div class="p-5 bg-gray-200 dark:bg-gray-800 text-left">
                    <form method="post"
                        @if (!empty($update_id))
                            wire:submit="update"
                        @else
                            wire:submit="insert"
                        @endif
                        enctype="multipart/form-data"
                    >
                        <div class="mb-1">
                            <label for="Name" class="my-label">Name</label>
                            <input type="text" wire:model="name" placeholder="Name" id="Name"
                                class="my-input focus:outline-none focus:shadow-outline">
                            @if ($errors->has('name'))
                                <div class="text-red-500">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                        <div class="mb-1">
                            <label for="Fee" class="my-label">Fee</label>
                            <input type="text" wire:model="fee" placeholder="Fee" id="Fee"
                                class="my-input focus:outline-none focus:shadow-outline">
                            @if ($errors->has('fee'))
                                <div class="text-red-500">{{ $errors->first('fee') }}</div>
                            @endif
                        </div>
                        <div class="mb-1">
                            <label for="Duration" class="my-label">Duration</label>
                            <input type="text" wire:model="duration" placeholder="Duration" id="Duration"
                                class="my-input focus:outline-none focus:shadow-outline">
                            @if ($errors->has('duration'))
                                <div class="text-red-500">{{ $errors->first('duration') }}</div>
                            @endif
                        </div>
                        <div class="mb-1">
                            <label class="my-label pt-0" for="image">Image</label>
                            <input wire:model="image" class="bg-white p-2 w-full block form-control @error('image') is-invalid @enderror"
                                id="image" type="file">
                            <div wire:loading="" wire:target="image" class="text-green-500">
                                Uploading Image...
                            </div>
                            @if ($errors->has('image'))
                                <div  class="text-red-500">{{ $errors->first('image') }}</div>
                            @endif
                            @if ($image)
                                <div>
                                    <img width="80" class="mt-1" src="{{ $image->temporaryUrl() }}"
                                        alt="">
                                </div>
                            @else
                                <div>
                                    <img width="80" class="mt-1" src="{{ asset('storage/' . $oldimage) }}"
                                        alt="">
                                </div>
                            @endif
                        </div>
                        <div class="flex justify-end items-center mt-8">
                            <button type="reset" class="btn btn-reset">Reset</button>
                            <button type="submit" class="btn-submit btn ml-4" wire:loading.remove @if (!empty($update_id)) wire:target="update" @else wire:target="insert" @endif>Save</button>
                            <button type="button" disabled class="btn-submit btn ml-4" wire:loading @if (!empty($update_id)) wire:target="update" @else wire:target="insert" @endif>Loading</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Students --}}
    <div class="fixed inset-0 bg-[black]/60 z-[999] @if ($is_Department) @else hidden @endif overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div x-transition x-transition.duration.300 class="panel border-0 p-0 rounded-lg w-full md:max-w-4xl my-8">
                <div class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-5 py-3">
                    <h5 class="font-bold text-lg text-blue-500">{{ $single_Department->name ?? '-' }}</h5>
                    <div class="flex justify-end items-center">
                        <button wire:click="removeDepartment" type="button" class="text-blue-500">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>
                        </button>
                    </div>
                </div>
                <div class="p-5 bg-gray-200 dark:bg-gray-800 text-left">
                    <div class="overflow-auto">
                        <table class="w-full">
                            <thead>
                                <tr>
                                    <th class="p-3 bg-gray-100 dark:bg-gray-800 text-center">SL</th>
                                    <th class="p-3 bg-gray-100 dark:bg-gray-800 text-center">Course</th>
                                    <th class="p-3 bg-gray-100 dark:bg-gray-800 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @forelse ($course as $data)
                                    <tr>
                                        <td class="p-3 border-b border-[#ebedf2] dark:border-[#191e3a] text-center">
                                            {{ $i++ }}
                                        </td>

                                        <td class="p-3 border-b border-[#ebedf2] dark:border-[#191e3a] text-center">
                                            {{ $data->name }}
                                        </td>

                                        <td class="p-3 border-b border-[#ebedf2] dark:border-[#191e3a] text-center">
                                            {{-- add Button --}}
                                            <button wire:click="addCourseToDepartment({{ $data->id }}, {{ $single_Department->id }})" class="btn btn-submit @if($single_Department->courses()->where('course_id', $data->id)->exists()) bg-red-500 @else @endif">
                                                @if($single_Department->courses()->where('course_id', $data->id)->exists())
                                                    Remove
                                                @else
                                                    Add
                                                @endif
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="20">
                                            <div class="flex justify-center items-center">
                                                <img src="{{ asset('empty.png') }}" alt="" class="w-[200px] opacity-40 dark:opacity-15 mt-10 select-none">
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
