<?php
use App\Http\Controllers\Admin\AdminSupervisorController;
use App\Http\Controllers\Admin\AdminSkillController;
use App\Http\Controllers\Admin\AdminAgentController;
use App\Http\Controllers\Admin\AdminReporterController;
use App\Http\Controllers\Admin\AdminGroupController;
use App\Http\Controllers\Supervisor\SupervisorAgentController;
use App\Http\Controllers\AuthController;
use App\Livewire\Admin\AdminAgentManager;
use App\Livewire\Admin\AdminChatHistory;
use App\Livewire\Admin\AdminDashboardExtended;
use App\Livewire\Admin\AdminGroupManager;
use App\Livewire\Admin\AdminReporterManager;
use App\Livewire\Admin\AdminSkillManager;
use App\Livewire\Admin\AdminSupervisorManager;
use App\Livewire\Admin\AdminProfile;
use App\Livewire\Login;
use App\Livewire\Reporter\ReporterChatHistory;
use App\Livewire\Reporter\ReporterDashboard;
use App\Livewire\Reporter\ReporterProfile;
use App\Livewire\Reporter\ReporterUsers;
use App\Livewire\Supervisor\SupervisorAgentManager;
use App\Livewire\Supervisor\SupervisorChatHistory;
use App\Livewire\Supervisor\SupervisorProfile;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\MessageController;
use App\Models\Agent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//Admin
Route::get('/dashboard', [AdminDashboardExtended::class, 'render'])->name('admin.dashboard');
Route::get('/chat-history', [AdminChatHistory::class, 'render'])->name('admin.chat-history');
Route::get('/agent', [AdminAgentManager::class, 'render'])->name('admin.agent');
Route::get('/supervisors', [AdminSupervisorManager::class, 'render'])->name('admin.supervisor');
Route::get('/reporter', [AdminReporterManager::class, 'render'])->name('admin.reporter');
Route::get('/groups', AdminGroupManager::class)->name('admin.group');
Route::get('/skill-manager', AdminSkillManager::class)->name('admin.skill');
Route::get('/profile', [AdminProfile::class, 'render'])->name('admin.profile');
Route::post('skills', [AdminSkillController::class, 'store'])->name('skills.store');
Route::delete('skills/{id}', [AdminSkillController::class, 'destroy'])->name('skills.destroy');
Route::put('skills/{skill}', [AdminSkillController::class, 'update'])->name('skills.update');
Route::post('admin/agents/store', [AdminAgentController::class, 'store'])->name('agents.store');
Route::get('/agents/edit/{emp_id}', [AdminAgentController::class, 'edit'])->name('agents.edit');
Route::post('/agents/update/{emp_id}', [AdminAgentController::class, 'update'])->name('agents.update');
Route::post('/agents/delete/{emp_id}', [AdminAgentController::class, 'destroy'])->name('agents.destroy');
Route::get('/agents/filter', [AdminAgentController::class, 'filter'])->name('agents.filter');
Route::get('/groups/filter', [AdminGroupController::class, 'filter'])->name('group.filter');
Route::post('/groups', [AdminGroupController::class, 'store'])->name('group.store');
Route::put('/groups/{group}', [AdminGroupController::class, 'update'])->name('group.update');
Route::delete('groups/{id}', [AdminGroupController::class, 'destroy'])->name('group.destroy');
Route::post('/admin/groups/search', [AdminGroupController::class, 'search'])->name('group.search');
Route::get('/admin/supervisor', [AdminSupervisorController::class, 'index'])->name('admin.supervisor.index');
Route::post('/admin/supervisor/add', [AdminSupervisorController::class, 'addSupervisor'])->name('admin.supervisor.add');
Route::get('/admin/supervisors/{id}/edit', [AdminSupervisorController::class, 'edit'])->name('admin.supervisor.edit');
Route::put('/admin/supervisors/{id}', [AdminSupervisorController::class, 'update'])->name('admin.supervisor.update');
Route::delete('/admin/supervisor/{id}', [AdminSupervisorController::class, 'delete'])->name('admin.supervisor.delete');
Route::get('/supervisor/search', [AdminSupervisorController::class, 'search'])->name('admin.supervisor.search');
Route::get('/reporters/filter', [AdminReporterController::class, 'filter'])->name('reporters.filter');
Route::post('/reporters/store', [AdminReporterController::class, 'store'])->name('reporters.store');
Route::post('/reporters/update/{emp_id}', [AdminReporterController::class, 'update'])->name('reporters.update');
Route::get('/reporters/edit/{emp_id}', [AdminReporterController::class, 'edit'])->name('reporters.edit');
Route::post('/reporters/delete/{emp_id}', [AdminReporterController::class, 'destroy'])->name('reporters.destroy');



//supervisor
Route::get('/supervisor-dashboard', [SupervisorChatHistory::class, 'render'])->name('supervisor.dashboard');
Route::get('/supervisor-chat-history', [SupervisorChatHistory::class, 'render'])->name('supervisor.chat.history');
Route::get('/supervisor-agent', [SupervisorAgentManager::class, 'render'])->name('supervisor.agent');
Route::get('/supervisor-profile', [SupervisorProfile::class, 'render'])->name('supervisor.profile');
Route::post('/supervisor/agents/store', [SupervisorAgentController::class, 'store'])->name('supervisor.agents.store');
Route::get('/supervisor/agents/edit/{emp_id}', [SupervisorAgentController::class, 'edit'])->name('supervisor.agents.edit');
Route::post('/supervisor/agents/update/{emp_id}', [SupervisorAgentController::class, 'update'])->name('supervisor.agents.update');
Route::post('/supervisor/agents/delete/{emp_id}', [SupervisorAgentController::class, 'destroy'])->name('supervisor.agents.destroy');
Route::get('/supervisor/agents/filter', [SupervisorAgentController::class, 'filter'])->name('supervisor.agents.filter');

//reporter
Route::get('/reporter-dashboard', [ReporterChatHistory::class, 'render'])->name('reporter.dashboard');
Route::get('/reporter-chat-history', [ReporterChatHistory::class, 'render'])->name('reporter.chat.history');
Route::get('/reporter-profile', [ReporterProfile::class, 'render'])->name('reporter.profile');
Route::get('/reporter-users', [ ReporterUsers::class, 'render'])->name('reporter.reporter-users');


//Agent
Route::get('/chat', [ChatController::class, 'index'])->name('agent.chat');
Route::post('/send-message', [ChatController::class, 'sendMessage']);
Route::get('/messages/{phoneNumber}', [ChatController::class, 'getMessages']);
Route::get('/get-latest-contacts', [ChatController::class, 'getLatestContacts'])->name('get.latest.contacts');
Route::get('/unread-messages', [ChatController::class, 'getUnreadMessages']);
Route::post('/mark-messages-read', [ChatController::class, 'markMessagesRead']);
Route::post('/deactivate-chat', [ChatController::class, 'deactivateInactiveChat']);

Route::post('/agent-ping', function (Request $request) {
    if (Auth::check() && Auth::user()->role === 'agent') {
        Agent::where('emp_id', Auth::user()->emp_id)->update(['is_online' => true]);
    }
    return response()->json(['status' => 'online']);
})->middleware('web');

Route::post('/logout-agent', function (Request $request) {
    if ($request->emp_id) {
        $agent = Agent::where('emp_id', $request->emp_id)->first();
        if ($agent) {
            $agent->update([
                'is_online' => false,
                'active_chats' => 0
            ]);
        }
    }
    return response()->json(['message' => 'Agent logged out']);
})->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]); // Disable CSRF



Route::post('/send-document', [ChatController::class, 'sendDocument'])->name('send.document');
Route::get('/document/{documentId}', [MessageController::class, 'download'])->name('document.download');
Route::get('/document/view/{documentId}', [MessageController::class, 'view'])->name('document.view');


