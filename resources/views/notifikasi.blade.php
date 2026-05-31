@extends('layouts.dashboard')

@section('title', 'Notifikasi – Smart Finder')

@section('styles')
    <style>
        .notif-header {
            border-bottom: 1px solid var(--gray-200);
            padding-bottom: 20px;
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .notif-title-wrap {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .notif-title-wrap svg {
            width: 28px;
            height: 28px;
            stroke: var(--blue);
            stroke-width: 2;
            fill: none;
        }

        .notif-title-text h1 {
            font-size: 24px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 4px;
        }

        .notif-title-text p {
            font-size: 14px;
            color: var(--gray-600);
        }

        .notif-filters {
            display: flex;
            gap: 12px;
            margin-bottom: 24px;
        }

        .notif-filter-btn {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            border: 1px solid var(--gray-300);
            color: var(--gray-600);
            background: var(--white);
            transition: all .2s;
        }

        .notif-filter-btn.active {
            background: var(--blue);
            color: var(--white);
            border-color: var(--blue);
        }

        .notif-section-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--dark);
            margin: 24px 0 16px 0;
        }

        .notif-card {
            display: flex;
            align-items: center;
            padding: 16px;
            background: var(--white);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-sm);
            margin-bottom: 12px;
            border: 1px solid var(--gray-200);
            text-decoration: none;
            position: relative;
            transition: all .2s;
        }

        .notif-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .notif-card.read {
            opacity: 0.7;
            background: #f9fafb;
        }

        .notif-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: #E0F2FE;
            color: var(--blue);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 18px;
            flex-shrink: 0;
            margin-right: 16px;
            overflow: hidden;
        }

        .notif-body {
            flex-grow: 1;
        }

        .notif-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 4px;
        }

        .notif-msg {
            font-size: 13px;
            color: var(--gray-600);
        }

        .notif-meta {
            text-align: right;
            font-size: 12px;
            color: var(--gray-500);
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 8px;
        }

        .notif-unread-dot {
            width: 10px;
            height: 10px;
            background: var(--blue);
            border-radius: 50%;
        }
    </style>
@endsection

@section('content')
    <div style="max-width: 800px; margin: 0 auto;">

        <div class="notif-header">
            <div class="notif-title-wrap">
                <svg viewBox="0 0 24 24">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                </svg>
                <div class="notif-title-text">
                    <h1>Notifikasi</h1>
                    <p>Lihat dan kelola notifikasimu</p>
                </div>
            </div>
            <form action="{{ route('notifikasi.readAll') }}" method="POST">
                @csrf @method('PATCH')
                <button class="btn-secondary" style="font-size:13px; padding:8px 16px;">Tandai Semua Dibaca</button>
            </form>
        </div>

        <div class="notif-filters">
            <a href="?filter=all" class="notif-filter-btn {{ $filter == 'all' ? 'active' : '' }}">Semua</a>
            <a href="?filter=unread" class="notif-filter-btn {{ $filter == 'unread' ? 'active' : '' }}">Belum Dibaca</a>
        </div>

        @if($todayNotifications->isEmpty() && $earlierNotifications->isEmpty())
            <div style="text-align:center; padding:60px 0; color:var(--gray-500);">
                <svg viewBox="0 0 24 24" style="width:64px;height:64px;stroke:var(--gray-300);fill:none;margin-bottom:16px;">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                </svg>
                <div style="font-size:18px; font-weight:600; color:var(--gray-700);">Belum ada notifikasi</div>
                <div style="font-size:14px;">Saat ini kotak notifikasi kamu bersih.</div>
            </div>
        @else

            @if($todayNotifications->isNotEmpty())
                <div class="notif-section-title">Hari Ini</div>
                @foreach($todayNotifications as $notif)
                    @include('components.notif-card', ['notif' => $notif])
                @endforeach
            @endif

            @if($earlierNotifications->isNotEmpty())
                <div class="notif-section-title">Sebelumnya</div>
                @foreach($earlierNotifications as $notif)
                    @include('components.notif-card', ['notif' => $notif])
                @endforeach
            @endif

        @endif

    </div>
@endsection