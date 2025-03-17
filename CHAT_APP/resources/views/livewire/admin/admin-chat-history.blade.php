@extends('layouts.app')

@section('sidebar')
    @livewire('admin.admin-sidebar')
@endsection

@section('dashboard')
    <!-- Exclude dashboard for this page -->
@endsection

@section('chat-dashboard')
    @livewire('admin.admin-chat-view-dashboard')
@endsection

@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat History</title>
    @livewireStyles
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <!-- Chat History Section Below -->
    <div class="container mt-3">
        <div class="card shadow bg-white">
            <div class="card-header bg-white">
                <h5 class="text-success mb-0">Chat History</h5>
            </div>
            <div class="card-body">
                <!-- Search and Filters -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <select class="form-select">
                            <option selected>Group</option>
                            <option value="1">G001</option> 
                            <option value="2">G002</option> 
                            <option value="3">G003</option> 
                            <option value="3">G004</option> 
                            <option value="3">G005</option> 
                            <option value="3">G006</option> 
                            <option value="3">G007</option> 
                            <option value="3">G008</option> 
                            <option value="3">G009</option> 
                            <option value="3">G0010</option> 
                            <option value="3">G0011</option> 
                            <option value="3">G0012</option> 
                            <option value="3">G0013</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="date" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-success w-100">Search</button>
                    </div>
                </div>

                <!-- Chat Table -->
                <table
                    id="table"
                    class="table table-bordered"
                    data-toggle="table"
                    data-pagination="true"
                    data-page-size="2"
                    data-sortable="false"
                >
                    <thead class="table-success">
                        <tr>
                            <th>Chat ID</th>
                            <th>Skill</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>G001_311224_001</td>
                            <td>
                                <span class="badge bg-success">English</span>
                                <span class="badge bg-success">Peo TV</span>
                            </td>
                            <td>2024/12/31</td>
                            <td>9.56</td>
                            <td>
                                <!-- Dropdown Action Button -->
                                <div class="dropdown">
                                    <button class="btn btn-outline-success btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-chat-dots"></i> Chat Options
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="bi bi-eye"></i> View Chat
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="bi bi-download"></i> Download
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="bi bi-info-circle"></i> Details
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    <tbody>
                        <tr>
                            <td>G001_311224_002</td>
                            <td>
                                <span class="badge bg-success">English</span>
                                <span class="badge bg-success">Peo TV</span>
                            </td>
                            <td>2024/12/31</td>
                            <td>8.56</td>
                            <td>
                                <!-- Dropdown Action Button -->
                                <div class="dropdown">
                                    <button class="btn btn-outline-success btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-chat-dots"></i> Chat Options
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="bi bi-eye"></i> View Chat
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="bi bi-download"></i> Download
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="bi bi-info-circle"></i> Details
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    <tbody>
                        <tr>
                            <td>G002_311224_001</td>
                            <td>
                                <span class="badge bg-success">English</span>
                                <span class="badge bg-success">Peo TV</span>
                            </td>
                            <td>2024/12/31</td>
                            <td>9.56</td>
                            <td>
                                <!-- Dropdown Action Button -->
                                <div class="dropdown">
                                    <button class="btn btn-outline-success btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-chat-dots"></i> Chat Options
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="bi bi-eye"></i> View Chat
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="bi bi-download"></i> Download
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="bi bi-info-circle"></i> Details
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    <tbody>
                        <tr>
                            <td>G002_311224_002</td>
                            <td>
                                <span class="badge bg-success">English</span>
                                <span class="badge bg-success">Peo TV</span>
                            </td>
                            <td>2024/12/25</td>
                            <td>9.56</td>
                            <td>
                                <!-- Dropdown Action Button -->
                                <div class="dropdown">
                                    <button class="btn btn-outline-success btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-chat-dots"></i> Chat Options
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="bi bi-eye"></i> View Chat
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="bi bi-download"></i> Download
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="bi bi-info-circle"></i> Details
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>
@endsection
