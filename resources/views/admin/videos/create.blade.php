@extends('layouts.app')

@section('title', 'Add Video — Admin — WolfNet')

@section('content')
<div class="pt-24 pb-12 px-4 md:px-12 max-w-screen-2xl mx-auto">
    <div class="max-w-2xl mx-auto">

        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('admin.content.index') }}" class="text-gray-500 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h1 class="text-2xl font-bold text-white">Add New Video</h1>
        </div>

        <div class="surface-card p-6 md:p-8">
            <form method="POST" action="{{ route('admin.content.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-300 mb-1.5">Title</label>
                    <input id="title" type="text" name="title" value="{{ old('title') }}" class="input-dark" required>
                    @error('title') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-300 mb-1.5">Type</label>
                        <select id="type" name="type" class="select-dark" required>
                            <option value="movie" {{ old('type') === 'movie' ? 'selected' : '' }}>Movie</option>
                            <option value="series" {{ old('type') === 'series' ? 'selected' : '' }}>Series</option>
                        </select>
                        @error('type') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="release_year" class="block text-sm font-medium text-gray-300 mb-1.5">Release Year</label>
                        <input id="release_year" type="number" name="release_year" value="{{ old('release_year') }}" class="input-dark" min="1900" max="{{ date('Y') + 1 }}">
                        @error('release_year') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-300 mb-1.5">Description</label>
                    <textarea id="description" name="description" rows="4" class="input-dark">{{ old('description') }}</textarea>
                    @error('description') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="language" class="block text-sm font-medium text-gray-300 mb-1.5">Language</label>
                        <input id="language" type="text" name="language" value="{{ old('language', 'en') }}" class="input-dark">
                        @error('language') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="is_premium" class="block text-sm font-medium text-gray-300 mb-1.5">Access</label>
                        <select id="is_premium" name="is_premium" class="select-dark">
                            <option value="0" {{ old('is_premium') == '0' ? 'selected' : '' }}>Free</option>
                            <option value="1" {{ old('is_premium') == '1' ? 'selected' : '' }}>Premium</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="thumbnail_url" class="block text-sm font-medium text-gray-300 mb-1.5">Thumbnail URL</label>
                    <input id="thumbnail_url" type="url" name="thumbnail_url" value="{{ old('thumbnail_url') }}" class="input-dark" placeholder="https://...">
                    @error('thumbnail_url') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="streaming_url" class="block text-sm font-medium text-gray-300 mb-1.5">Streaming URL</label>
                    <input id="streaming_url" type="url" name="streaming_url" value="{{ old('streaming_url') }}" class="input-dark" placeholder="https://...">
                    @error('streaming_url') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                </div>

                {{-- Genres --}}
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Genres</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach($genres as $genre)
                            <label class="cursor-pointer">
                                <input type="checkbox" name="genres[]" value="{{ $genre->id }}"
                                       class="hidden peer"
                                       {{ in_array($genre->id, old('genres', [])) ? 'checked' : '' }}>
                                <span class="badge bg-surface-600 text-gray-400 border border-surface-400 peer-checked:bg-brand/20 peer-checked:text-brand peer-checked:border-brand/40 transition-all">
                                    {{ $genre->name }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                    @error('genres') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="btn-primary">Create Video</button>
                    <a href="{{ route('admin.content.index') }}" class="btn-outline btn-sm">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
