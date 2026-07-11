@extends('core::components.layouts.master')
<link rel="stylesheet" href="{{ asset('css/document.css') }}">

@section('content')
    <div class="container">

        <div class="document-card">
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

            <!-- Header -->
            <div class="document-header">
                <div>
                    <h2>
                        📄 เอกสารทั้งหมด
                    </h2>
                    <p>
                        รายการเอกสารผู้ป่วย
                    </p>
                </div>

                <!-- Document Tabs -->
                <div class="document-tabs">
                    <a href="{{ route('pt33.create') }}" class="{{ request()->routeIs('pt33.create') ? 'active' : '' }}">
                        พท.33
                    </a>

                    <a href="{{ route('pt28.create') }}" class="{{ request()->routeIs('pt28.create') ? 'active' : '' }}">
                        พท.28
                    </a>

                    <a href="{{ route('medical-certificate.create') }}"
                        class="{{ request()->routeIs('medical-certificate.create') ? 'active' : '' }}">
                        ใบรับรองแพทย์
                    </a>
                </div>
            </div>

            <!-- Filter -->

            <form method="GET" action="{{ route('documents.index') }}">
                <div class="filter-box">

                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="🔎 ค้นหาเลขเอกสาร / ชื่อผู้ป่วย">

                    <select name="type">
                        <option value="">ทุกประเภท</option>
                        <option value="PT33" {{ request('type') == 'PT33' ? 'selected' : '' }}>
                            PT33
                        </option>
                        <option value="PT28" {{ request('type') == 'PT28' ? 'selected' : '' }}>
                            PT28
                        </option>
                        <option value="MedicalCertificate" {{ request('type') == 'MedicalCertificate' ? 'selected' : '' }}>
                            MedicalCertificate
                        </option>
                    </select>

                    <select name="status">
                        <option value="">ทุกสถานะ</option>
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

                    @if (request()->filled('search') || request()->filled('type') || request()->filled('status'))
                        <a href="{{ route('documents.index') }}" class="btn-reset">
                            ล้างตัวกรอง
                        </a>
                    @endif

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
                                            ภท.33
                                        </span>
                                    @elseif ($item->type == 'PT28')
                                        <span class="badge purple">
                                            ภท.28
                                        </span>
                                    @else
                                        <span class="badge purple">
                                            ใบรับรองแพทย์
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
