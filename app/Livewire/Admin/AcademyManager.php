<?php

namespace App\Livewire\Admin;

use App\Models\Academy;
use App\Models\Enrollment; 
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AcademyManager extends Component
{
    use WithFileUploads;

    // Properti untuk Form (Admin)
    public $title, $category, $price, $instructor_name, $thumbnail, $description;
    
    // Properti untuk Detail (User)
    public $academy;

    /**
     * Fungsi Mount: Menjalankan logika saat halaman detail diakses via slug
     */
    public function mount($slug = null)
    {
        if ($slug) {
            $this->academy = Academy::where('slug', $slug)->firstOrFail();
        }
    }

    /**
     * Fungsi Save: Digunakan oleh Admin untuk tambah data
     */
    public function save()
    {
        $this->validate([
            'title' => 'required',
            'category' => 'required',
            'description' => 'required', 
            'price' => 'required|numeric',
            'instructor_name' => 'required',
            'thumbnail' => 'nullable|image|max:1024',
        ]);

        $path = $this->thumbnail ? $this->thumbnail->store('thumbnails', 'public') : null;

        Academy::create([
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'category' => $this->category,
            'description' => $this->description,            
            'price' => $this->price,
            'instructor_name' => $this->instructor_name,
            'thumbnail' => $path,         
        ]);
        
        $this->reset(['title', 'category', 'price', 'instructor_name', 'thumbnail', 'description']);
        session()->flash('message', 'Academy Course created successfully! 🚀');
    }

    /**
     * Fungsi Delete: Digunakan oleh Admin
     */
    public function delete($id)
    {
        $academy = Academy::findOrFail($id);
        
        if ($academy->thumbnail) {
            Storage::disk('public')->delete($academy->thumbnail);
        }

        $academy->delete();
        session()->flash('message', 'Course deleted successfully!');
    }

    /**
     * Fungsi Enroll: Digunakan oleh User di halaman detail
     */
    public function enroll($academyId)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $targetAcademy = Academy::findOrFail($academyId);

        // Cek pendaftaran ganda
        $exists = Enrollment::where('user_id', auth()->id())
                            ->where('academy_id', $targetAcademy->id)
                            ->exists();

        if ($exists) {
            session()->flash('message', 'You are already enrolled!');
            return;
        }

        // REDIRECT KE CHECKOUT - Ini harus di atas logic pembuatan record jika ingin lewat pembayaran dulu
        return redirect()->route('checkout', ['slug' => $targetAcademy->slug]);
    }

    /**
     * Fungsi Render: Memisahkan tampilan Admin dan User
     */
    public function render()
{
    // Jika ada properti $academy (berarti ini halaman detail user)
    if ($this->academy) {
        // Path disesuaikan dengan struktur folder resources/views/user/
        // Layout disesuaikan dengan struktur components/layouts/
        return view('user.academy-show')->layout('components.layouts.app');
    }

    // Jika tidak ada (berarti ini halaman admin manager)
    return view('livewire.admin.academy-manager', [
        'academies' => \App\Models\Academy::latest()->get()
    ]);
}

    
    
}