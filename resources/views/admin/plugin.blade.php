@extends('layouts.app')
@section('title', 'Plugin Releases')
@section('page-title', 'Plugin Releases')

@section('content')

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
<div class="alert alert-error">{{ session('error') }}</div>
@endif

{{-- Current live version --}}
<div class="card" style="margin-bottom:24px;">
    <div class="card-label">Live Version</div>
    @if($latest)
    <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap;">
        <span style="font-size:28px;font-weight:800;color:var(--teal);letter-spacing:-1px;">v{{ $latest->version }}</span>
        <div style="font-size:13px;color:var(--g500);line-height:1.7;">
            <div>Requires WP <strong style="color:var(--g900);">{{ $latest->requires_wp }}+</strong> &nbsp;|&nbsp; PHP <strong style="color:var(--g900);">{{ $latest->requires_php }}+</strong> &nbsp;|&nbsp; Tested to <strong style="color:var(--g900);">WP {{ $latest->tested_wp }}</strong></div>
            <div style="margin-top:2px;">Published {{ $latest->created_at->format('d M Y, H:i') }}</div>
        </div>
        <a href="{{ url('/api/v1/plugin/version') }}" target="_blank" class="btn btn-sm btn-outline" style="margin-left:auto;">
            Preview API response
        </a>
    </div>
    @if($latest->changelog)
    <div style="margin-top:14px;padding:12px 16px;background:var(--g50);border:1px solid var(--g200);border-radius:8px;font-size:13px;color:var(--g700);line-height:1.6;">
        {!! $latest->changelog !!}
    </div>
    @endif
    @else
    <p style="color:var(--g400);font-size:14px;">No release published yet. Upload one below.</p>
    @endif
</div>

{{-- Publish new release --}}
<div class="card" style="margin-bottom:28px;">
    <div class="card-label">Publish New Release</div>
    <form method="POST" action="{{ route('admin.plugin.store') }}" enctype="multipart/form-data">
        @csrf

        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;margin-bottom:16px;">
            <div class="form-group" style="margin:0;">
                <label>Version <span style="color:var(--red)">*</span></label>
                <input type="text" name="version" value="{{ old('version') }}" required
                       placeholder="1.3.2" pattern="\d+\.\d+\.\d+"
                       title="Semver format: 1.2.3"
                       class="form-input">
                @error('version')<div class="form-err">{{ $message }}</div>@enderror
            </div>
            <div class="form-group" style="margin:0;">
                <label>Requires WP <span style="color:var(--red)">*</span></label>
                <input type="text" name="requires_wp" value="{{ old('requires_wp', $latest?->requires_wp ?? '5.8') }}" required
                       placeholder="5.8" class="form-input">
                @error('requires_wp')<div class="form-err">{{ $message }}</div>@enderror
            </div>
            <div class="form-group" style="margin:0;">
                <label>Tested to WP <span style="color:var(--red)">*</span></label>
                <input type="text" name="tested_wp" value="{{ old('tested_wp', $latest?->tested_wp ?? '6.7') }}" required
                       placeholder="6.7" class="form-input">
                @error('tested_wp')<div class="form-err">{{ $message }}</div>@enderror
            </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
            <div class="form-group" style="margin:0;">
                <label>Requires PHP <span style="color:var(--red)">*</span></label>
                <input type="text" name="requires_php" value="{{ old('requires_php', $latest?->requires_php ?? '7.4') }}" required
                       placeholder="7.4" class="form-input">
                @error('requires_php')<div class="form-err">{{ $message }}</div>@enderror
            </div>
            <div class="form-group" style="margin:0;">
                <label>Plugin ZIP file</label>
                <input type="file" name="zip_file" accept=".zip"
                       style="width:100%;padding:10px 14px;border:1.5px solid var(--g200);border-radius:8px;font-size:13.5px;font-family:inherit;background:var(--g50);color:var(--g700);cursor:pointer;">
                <div style="font-size:11.5px;color:var(--g400);margin-top:4px;">Max 50 MB. Leave blank to keep the existing zip and just update the version metadata.</div>
                @error('zip_file')<div class="form-err">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="form-group" style="margin-bottom:20px;">
            <label>Changelog</label>
            <textarea id="adiq-changelog" name="changelog" rows="6">{{ old('changelog') }}</textarea>
            @error('changelog')<div class="form-err">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="btn btn-primary">Publish Release</button>
    </form>
</div>

{{-- Release history --}}
@if($releases->count() > 0)
<div class="card-label" style="margin-bottom:12px;">Release History</div>
<div class="tbl-wrap">
    <table class="tbl">
        <thead>
            <tr>
                <th>Version</th>
                <th>Requires</th>
                <th>Zip</th>
                <th>Changelog</th>
                <th>Published</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($releases as $release)
            <tr>
                <td>
                    <span style="font-weight:700;color:{{ $release->id === $latest?->id ? 'var(--teal)' : 'var(--g900)' }};">
                        v{{ $release->version }}
                    </span>
                    @if($release->id === $latest?->id)
                        <span class="badge badge-teal" style="margin-left:6px;font-size:10px;">Live</span>
                    @endif
                </td>
                <td style="font-size:12.5px;color:var(--g500);">
                    WP {{ $release->requires_wp }}+ &nbsp;/&nbsp; PHP {{ $release->requires_php }}+
                </td>
                <td>
                    @if($release->zip_path)
                        <span class="badge badge-green" style="font-size:11px;">Uploaded</span>
                    @else
                        <span class="badge badge-gray" style="font-size:11px;">Metadata only</span>
                    @endif
                </td>
                <td style="font-size:12.5px;color:var(--g600);max-width:260px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"
                    title="{{ $release->changelog ? strip_tags($release->changelog) : '' }}">
                    {{ $release->changelog ? \Illuminate\Support\Str::limit(strip_tags($release->changelog), 60) : '-' }}
                </td>
                <td style="font-size:12px;color:var(--g400);white-space:nowrap;">
                    {{ $release->created_at->format('d M Y') }}
                </td>
                <td>
                    @if($release->id !== $latest?->id)
                    <form method="POST" action="{{ route('admin.plugin.destroy', $release) }}">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-xs btn-danger"
                            onclick="return confirm('Delete this release record? The zip file will also be removed.')">
                            Delete
                        </button>
                    </form>
                    @else
                        <span style="font-size:12px;color:var(--g400);">Current</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

@push('scripts')
<script src="https://cdn.tiny.cloud/1/7ks0cciiaqyy42xavs54ffhzabryhac69ofh5d234mc3czfw/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
tinymce.init({
    selector: '#adiq-changelog',
    height: 260,
    menubar: false,
    plugins: 'lists link',
    toolbar: 'bold italic | bullist numlist | link | removeformat',
    content_style: 'body { font-family: inherit; font-size: 14px; color: #111; line-height: 1.6; }',
    branding: false,
    promotion: false,
});
</script>
@endpush

@endsection
