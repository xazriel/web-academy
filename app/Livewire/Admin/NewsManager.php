<?php

namespace App\Livewire\Admin;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class NewsManager extends Component
{
    use WithFileUploads;

    public $title, $content, $thumbnail, $status = 'published';

    public function save()
    {
        $this->validate([
            'title' => 'required|min:5',
            'content' => 'required',
            'thumbnail' => 'image|max:1024', // Max 1MB
        ]);

        // Simpan gambar ke folder storage/app/public/thumbnails
        $imageName = $this->thumbnail->store('thumbnails', 'public');

        Post::create([
            'user_id' => auth()->id(),
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'content' => $this->content,
            'thumbnail' => $imageName,
            'status' => $this->status,
        ]);

        // Reset input form setelah berhasil simpan
        $this->reset(['title', 'content', 'thumbnail']);

        session()->flash('message', 'Berita berhasil diterbitkan!');
        
        // Opsional: Jika ingin tetap di halaman yang sama tanpa refresh, 
        // jangan gunakan redirect. Livewire akan otomatis update tabelnya.
    }

    public function delete($id)
    {
        $post = Post::find($id);

        if ($post) {
            // Hapus file gambar dari folder storage agar tidak menumpuk
            if ($post->thumbnail) {
                Storage::disk('public')->delete($post->thumbnail);
            }

            // Hapus data dari database
            $post->delete();

            session()->flash('message', 'Berita berhasil dihapus!');
        }
    }

    public function render()
    {
        return view('livewire.admin.news-manager', [
            'posts' => Post::latest()->get()
        ]);
    }
}