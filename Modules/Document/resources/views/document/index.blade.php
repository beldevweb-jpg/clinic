@extends('core::components.layouts.master')
<link rel="stylesheet" href="{{ asset('css/document.css') }}">

@section('content')
    <div class="container">

        <div class="document-card">


            <!-- Header -->
            <div class="document-header">
                <div>
                    <h2>
                        📄 เอกสารทั้งหมด
                    </h2>
                    <p>
                        รายการเอกสารผู้ป่วย PT33 และ PT28
                    </p>
                </div>

                <!-- Document Tabs -->
                <div class="document-tabs">
                    <a href="{{ route('pt33.index') }}" class="{{ request()->routeIs('pt33.index') ? 'active' : '' }}">
                        พท.33
                    </a>

                    <a href="{{ route('pt28.index') }}" class="{{ request()->routeIs('pt28.index') ? 'active' : '' }}">
                        พท.28
                    </a>
                </div>
            </div>

            <!-- Filter -->

            <form method="GET" action="{{ route('documents.index') }}">

                <div class="filter-box">
                    {{-- แจ้งเตือน --}}
                    @if (session('success'))
                        <div class="alert success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert error">
                            @foreach ($errors->all() as $error)
                                <div>• {{ $error }}</div>
                            @endforeach
                        </div>
                    @endif
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="🔎 ค้นหาเลขเอกสาร / ชื่อผู้ป่วย">
                    <select name="type">
                        <option value="">
                            ทุกประเภท
                        </option>

                        <option value="PT33" {{ request('type') == 'PT33' ? 'selected' : '' }}>
                            PT33
                        </option>

                        <option value="PT28" {{ request('type') == 'PT28' ? 'selected' : '' }}>
                            PT28
                        </option>
                    </select>

                    <select name="status">
                        <option value="">
                            ทุกสถานะ
                        </option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>
                            ร่าง
                        </option>

                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                            สำเร็จ
                        </option>

                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                            ยกเลิก
                        </option>
                    </select>
                    <button type="submit">
                        ค้นหา
                    </button>
                </div>
            </form>

            <!-- Summary -->
            <div class="summary">
                <div>
                    <span>ทั้งหมด</span>
                    <strong>
                        {{ $document->total() }}
                    </strong>
                </div>
                <div>
                    <span>ร่าง</span>
                    <strong>
                        {{ $draftCount ?? 0 }}
                    </strong>
                </div>
                <div>
                    <span>สำเร็จ</span>
                    <strong>
                        {{ $completedCount ?? 0 }}
                    </strong>
                </div>
                <div>
                    <span>ยกเลิก</span>
                    <strong>
                        {{ $cancelledCount ?? 0 }}
                    </strong>
                </div>
            </div>
            <!-- Table -->
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>
                                เลขเอกสาร
                            </th>

                            <th>
                                ผู้ป่วย
                            </th>

                            <th>
                                ประเภท
                            </th>

                            <th>
                                วันที่
                            </th>

                            <th>
                                สถานะ
                            </th>

                            <th>
                                จัดการ
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($document as $item)
                            <tr>
                                <td>
                                    {{ $item->document_no }}
                                </td>

                                <td>
                                    {{ $item->patient->firstname ?? '-' }}
                                    {{ $item->patient->lastname ?? '' }}
                                </td>
                                <td>
                                    @if ($item->type == 'PT33')
                                        <span class="badge blue">
                                            PT33
                                        </span>
                                    @else
                                        <span class="badge purple">
                                            PT28
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    {{ $item->created_at->format('d/m/Y') }}
                                </td>
                                <td>
                                    @if ($item->status == 'completed')
                                        <span class="status success">
                                            สำเร็จ
                                        </span>
                                    @elseif($item->status == 'draft')
                                        <span class="status warning">
                                            ร่าง
                                        </span>
                                    @else
                                        <span class="status danger">
                                            ยกเลิก
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-buttons">

                                        {{-- ดูเอกสาร --}}
                                        <a href="{{ route('documents.view', $item->id) }}" target="_blank"
                                            class="btn btn-primary">
                                            ดูเอกสาร
                                        </a>


                                        {{-- แก้ไขเอกสาร --}}
                                        <a href="{{ route('documents.edit', $item->id) }}" class="btn-action btn-edit">
                                            ✏️ แก้ไขเอกสาร
                                        </a>


                                        {{-- ลบเอกสาร --}}
                                        <form action="{{ route('documents.destroy', $item->id) }}" method="POST"
                                            style="display:inline">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn-action btn-delete"
                                                onclick="return confirm('ยืนยันลบเอกสาร?')">

                                                🗑 ลบเอกสาร

                                            </button>

                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" align="center">
                                    ไม่พบข้อมูลเอกสาร
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div style="margin-top:20px">
                {{ $document->links() }}
            </div>
        </div>
    </div>
@endsection
