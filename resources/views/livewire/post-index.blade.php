<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Post Index') }}</div>

                <div class="card-body">
                    <button class="btn btn-success" wire:click="showPostmodal">Create</button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Launch demo modal
                      </button>
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">First</th>
                            <th scope="col">Last</th>
                            <th scope="col">Handle</th>
                          </tr>
                        </thead>
                        <tbody>
                        @foreach ($postindexs as $postindex)
                          <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                </div>

                <!-- Button trigger modal -->
                <!-- Modal -->
                <div class="card" wire:model="showingPostModal">
                    <div class="card-header">
                        <h3>Create title</h3>
                    </div>
                    <div class="card-body">
                        <form enctype="multipart/form-data">
                            <div class="sm:col-span-6">
                                <label for="title" class="block text-sm font-medium text-gray-700"> Post Title </label>
                                <div class="mt-1">
                                    <input type="text" id="title" wire:model.lazy="title" name="title"
                                        class="block w-full  appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                                </div>
                                @error('title')
                                    <span class="text-red-400">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="sm:col-span-6">
                                <label for="title" class="block text-sm font-medium text-gray-700"> Post Image </label>
                                @if ($oldImage)
                                    Old Image:
                                    <img src="{{ Storage::url($oldImage) }}">
                                @endif
                                @if ($newImage)
                                    Photo Preview:
                                    <img src="{{ $newImage->temporaryUrl() }}">
                                @endif
                                <div class="mt-1">
                                    <input type="file" id="image" wire:model="newImage" name="newImage"
                                        class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                                </div>
                                @error('newImage')
                                    <span class="text-red-400">{{ $message }}</span>
                                @enderror
    
                            </div>
                            <div class="sm:col-span-6 pt-5">
                                <label for="body" class="block text-sm font-medium text-gray-700">Body</label>
                                <div class="mt-1">
                                    <textarea id="body" rows="3" wire:model.lazy="body"
                                        class="shadow-sm focus:ring-indigo-500 appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"></textarea>
                                </div>
                                @error('body')
                                    <span class="text-red-400">{{ $message }}</span>
                                @enderror
                            </div>
                        </form>
                        <button class="btn btn-success" wire:click="storePost">Store</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>