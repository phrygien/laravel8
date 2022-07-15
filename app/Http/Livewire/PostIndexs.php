<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\PostIndex;

class PostIndexs extends Component
{
    public $showingPostModal = false;

    public $title;
    public $newImage;
    public $body;
    public $oldImage;
    public $isEditMode = false;
    public $postindex;

    public function render()
    {
        return view('livewire.post-index',['postindexs' => PostIndex::all()])
        ->layout('layouts.app');
    }

    public function showPostmodal()
    {
        $this->reset();
        $this->showingPostModal = true;
    }

    public function storePost()
    {
        $this->validate([
            'newImage' => 'image|max:1024',
            'title' => 'required',
            'body' => 'required'
        ]);

        $image = $this->newImage->store('public/posts');

        PostIndex::create([
            'title' => $this->title,
            'image' => $image,
            'body' => $this->body,
        ]);
        $this->reset();
    }

    public function showEditPostModal($id)
    {
        $this->postindex = PostIndex::findOrFail($id);
        $this->title = $this->postindex->title;
        $this->body = $this->postindex->body;
        $this->oldImage = $this->postindex->image;
        $this->isEditMode = true;
        $this->showingPostModal = true;
    }

    public function updatePost()
    {
        $this->validate([
            'title' => 'required',
            'body' => 'required'
        ]);
        $image = $this->postindex->image;
        if ($this->newImage) {
            $image = $this->newImage->store('public/posts');
        }

        $this->postindex->update([
            'title' => $this->title,
            'image' => $image,
            'body' => $this->body
        ]);
        $this->reset();
    } 

    public function deletePost($id)
    {
        $postindex = PostIndex::findOrFail($id);
        Storage::delete($postindex->image);
        $postindex->delete();
        $this->reset();
    }
}
