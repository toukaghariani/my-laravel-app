@extends('layouts.app')

@section('title', 'Manage Videos — Admin — WolfNet')

@section('content')
<div class="pt-24 pb-12 px-4 md:px-12 max-w-screen-2xl mx-auto">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white mb-1">Manage Videos</h1>
            <p class="text-gray-500 text-sm">{{ $contents->total() }} titles total</p>
        </div>
        <a href="{{ route('admin.content.create') }}" class="btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add Video
        </a>
    </div>

    <div class="surface-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Thumbnail</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Genres</th>
                        <th>Premium</th>
                        <th>Year</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contents as $content)
                        <tr>
                            <td>
                                <div class="w-12 h-16 rounded bg-surface-600 overflow-hidden flex-shrink-0">
                                    @if($content->thumbnail_url)
                                        <img src="{{ $content->thumbnail_url }}" alt="" class="w-full h-full object-cover">
                                    @endif
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('content.show', $content) }}" class="text-white font-medium hover:text-brand transition-colors">
                                    {{ $content->title }}
                                </a>
                            </td>
                            <td><span class="capitalize">{{ $content->type }}</span></td>
                            <td>
                                @if($content->genres->count())
                                    <span class="text-xs text-gray-500">{{ $content->genres->pluck('name')->join(', ') }}</span>
                                @else
                                    <span class="text-gray-600">—</span>
                                @endif
                            </td>
                            <td>
                                @if($content->isPremium())
                                    <span class="badge badge-premium text-[10px]">PREMIUM</span>
                                @else
                                    <span class="badge badge-free text-[10px]">FREE</span>
                                @endif
                            </td>
                            <td>{{ $content->release_year ?? '—' }}</td>
                            <td class="text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.content.edit', $content) }}" class="text-gray-400 hover:text-white transition-colors" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.content.destroy', $content) }}" onsubmit="return confirm('Delete this video?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-gray-400 hover:text-red-400 transition-colors" title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-gray-500 py-8">No videos added yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $contents->links() }}
    </div>
</div>
@endsection
