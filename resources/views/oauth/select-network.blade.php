<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select GAM Network — adIQ by Percivo</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --teal:#2DBDB5;--teal-d:#1FA89F;--dark:#0D1117;--g50:#F8F9FB;
            --g100:#F1F3F5;--g200:#E2E5E9;--g400:#9CA3AF;--g500:#6B7280;
            --g700:#374151;--g900:#111827;--red:#DC2626;
        }
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Inter',-apple-system,BlinkMacSystemFont,sans-serif;background:var(--g50);color:var(--g900);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px;}
        .card{background:#fff;border:1px solid var(--g200);border-radius:12px;padding:36px;width:100%;max-width:500px;box-shadow:0 4px 24px rgba(0,0,0,0.06);}
        .brand{display:flex;flex-direction:column;margin-bottom:28px;}
        .brand .adiq{font-size:20px;font-weight:800;color:var(--dark);letter-spacing:-0.5px;}
        .brand .by-percivo{font-size:10px;font-weight:500;color:var(--teal);letter-spacing:0.06em;text-transform:uppercase;margin-top:2px;}
        h2{font-size:17px;font-weight:700;color:var(--g900);margin-bottom:6px;}
        .sub{font-size:13px;color:var(--g500);margin-bottom:24px;line-height:1.5;}
        .email-chip{display:inline-flex;align-items:center;gap:6px;background:rgba(45,189,181,.08);border:1px solid rgba(45,189,181,.25);border-radius:20px;padding:3px 10px;font-size:12px;font-weight:500;color:var(--teal);margin-bottom:24px;}
        .form-label{display:block;font-size:12.5px;font-weight:500;color:var(--g700);margin-bottom:6px;}
        select{width:100%;padding:11px 14px;border:1.5px solid var(--g200);border-radius:8px;font-size:14px;font-family:inherit;background:var(--g50);color:var(--g900);appearance:none;-webkit-appearance:none;background-image:url("data:image/svg+xml,%3Csvg width='12' height='8' viewBox='0 0 12 8' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%236B7280' stroke-width='1.5' stroke-linecap='round'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 14px center;padding-right:36px;cursor:pointer;transition:border-color .15s;}
        select:focus{border-color:var(--teal);outline:none;box-shadow:0 0 0 3px rgba(45,189,181,.1);background-color:#fff;}
        .select-wrap{margin-bottom:24px;}
        .btn{display:flex;align-items:center;justify-content:center;gap:8px;width:100%;padding:12px;border-radius:8px;font-size:15px;font-weight:600;font-family:inherit;cursor:pointer;border:1px solid transparent;transition:all .12s;text-decoration:none;text-align:center;}
        .btn-primary{background:var(--teal);color:#fff;border-color:var(--teal);}
        .btn-primary:hover{background:var(--teal-d);}
        .btn-outline{background:#fff;color:var(--g700);border-color:var(--g200);margin-top:10px;}
        .btn-outline:hover{background:var(--g50);}
        .alert-error{padding:12px 14px;background:#FEF2F2;border:1px solid #FECACA;border-radius:8px;font-size:13px;color:var(--red);margin-bottom:20px;line-height:1.5;}
        .divider{border:none;border-top:1px solid var(--g100);margin:20px 0;}
        .network-hint{font-size:12px;color:var(--g400);margin-top:8px;line-height:1.5;}
    </style>
</head>
<body>
<div class="card">
    <div class="brand">
        <span class="adiq">adIQ</span>
        <span class="by-percivo">by Percivo</span>
    </div>

    <h2>Connect GAM Network</h2>
    <p class="sub">Select the Google Ad Manager network to link to your WordPress property.</p>

    <div class="email-chip">
        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2M12 11a4 4 0 100-8 4 4 0 000 8z"/>
        </svg>
        Authenticated as {{ $email }}
    </div>

    @if(empty($networks))
        <div class="alert-error">
            No GAM networks found for this Google account. Ensure the account has access to at least one Ad Manager network, then try reconnecting from the WordPress plugin.
        </div>
        <a href="{{ $redirectUri }}" class="btn btn-outline">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
            Return to WordPress
        </a>
    @else
        <form method="POST" action="{{ route('gam.oauth.select-network') }}">
            @csrf
            <input type="hidden" name="redirect_uri" value="{{ $redirectUri }}">
            <input type="hidden" name="network_name" id="network_name" value="{{ $networks[0]['displayName'] ?? '' }}">

            <div class="select-wrap">
                <label class="form-label" for="network_id">Ad Manager Network</label>
                <select name="network_id" id="network_id">
                    @foreach($networks as $network)
                        <option value="{{ $network['networkCode'] ?? '' }}"
                                data-name="{{ $network['displayName'] ?? $network['networkCode'] ?? '' }}">
                            {{ $network['displayName'] ?? $network['networkCode'] ?? 'Unknown Network' }}
                            &nbsp;·&nbsp; #{{ $network['networkCode'] ?? '' }}
                        </option>
                    @endforeach
                </select>
                <p class="network-hint">This network's ad units will be importable from the adIQ plugin inside WordPress.</p>
            </div>

            <button type="submit" class="btn btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
                </svg>
                Connect Network
            </button>
        </form>

        <hr class="divider">
        <a href="{{ $redirectUri }}" class="btn btn-outline" style="font-size:13.5px;">
            Cancel — return to WordPress
        </a>

        <script>
            document.getElementById('network_id').addEventListener('change', function () {
                document.getElementById('network_name').value = this.selectedOptions[0].dataset.name;
            });
        </script>
    @endif
</div>
</body>
</html>
