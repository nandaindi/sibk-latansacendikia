<?php $__env->startSection('title', 'Login – Bimbingan Konseling'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex flex-col md:flex-row flex-1 w-full min-h-screen bg-white overflow-hidden">

    <!-- ── LEFT PANEL ── -->
    <div class="flex-1 bg-[#f0fafa] flex flex-col items-center justify-center pt-10 px-7 pb-7 md:py-12 md:px-10 gap-7 relative overflow-hidden min-h-auto md:min-h-screen before:content-[''] before:absolute before:-top-20 before:-left-20 before:w-[260px] before:h-[260px] before:rounded-full before:bg-[rgba(26,148,136,0.07)] after:content-[''] after:absolute after:-bottom-[60px] after:-right-[60px] after:w-[200px] after:h-[200px] after:rounded-full after:bg-[rgba(26,148,136,0.07)]">
        
        <!-- Ilustrasi SVG Tema BK -->
        <style>
            @keyframes float {
                0%, 100% { transform: translateY(0); }
                50%       { transform: translateY(-10px); }
            }
        </style>
        <div class="w-[200px] md:w-[280px] h-auto relative z-10 animate-[float_4s_ease-in-out_infinite] [&>svg]:w-full [&>svg]:h-auto">
            <?php echo file_get_contents(public_path('img/login.svg')); ?>

        </div>

        <div class="text-center relative z-10 w-full font-caveat mt-2 text-black">
            <p class="text-[1.4rem] leading-[1.4]">Bersama BK, setiap cerita adalah awal.</p>
            <p class="text-[1.2rem] leading-[1.4]">Setiap langkah kecil adalah gerbang menuju perubahan besar.</p>
        </div>
    </div>

    <!-- ── RIGHT PANEL ── -->
    <div class="flex-1 flex flex-col justify-center bg-white min-h-auto md:min-h-screen pt-8 px-7 pb-12 md:py-14 md:px-[12%]">
        <div class="text-center">
            <h1 class="text-[1.6rem] md:text-[2rem] font-bold text-[#1a1a1a] mb-2">Login</h1>
            <p class="text-[0.875rem] text-[#888] mb-9">Masuk ke akun Anda untuk melanjutkan</p>
        </div>

        <?php if($errors->any()): ?>
            <div class="bg-[#fff0f0] border border-[#ffc5c5] rounded-[10px] py-3 px-4 text-[0.84rem] text-[#c0392b] mb-5">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div><?php echo e($error); ?></div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('login')); ?>" novalidate>
            <?php echo csrf_field(); ?>

            <!-- Username -->
            <div class="relative mb-[22px]">
                <label class="block text-[0.82rem] font-semibold text-[#555] mb-2 tracking-[0.3px]" for="username">Username</label>
                <div class="relative">
                    <span class="absolute left-[14px] top-1/2 -translate-y-1/2 text-[#aaa] pointer-events-none">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </span>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        class="w-full py-[13px] pr-[14px] pl-[42px] border-[1.5px] border-[#e0e0e0] rounded-[10px] text-[0.9rem] font-sans text-[#333] bg-[#fafafa] transition-all duration-250 outline-none focus:border-[#1a9488] focus:shadow-[0_0_0_3px_rgba(26,148,136,0.12)] focus:bg-white <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-[#e74c3c] <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        value="<?php echo e(old('username')); ?>"
                        placeholder="Masukkan username"
                        required
                        autofocus
                        autocomplete="username"
                    >
                </div>
                <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="text-[0.78rem] text-[#e74c3c] mt-[5px]"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Password -->
            <div class="relative mb-[22px]">
                <label class="block text-[0.82rem] font-semibold text-[#555] mb-2 tracking-[0.3px]" for="password">Password</label>
                <div class="relative">
                    <span class="absolute left-[14px] top-1/2 -translate-y-1/2 text-[#aaa] pointer-events-none">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                    </span>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="w-full py-[13px] pr-[14px] pl-[42px] border-[1.5px] border-[#e0e0e0] rounded-[10px] text-[0.9rem] font-sans text-[#333] bg-[#fafafa] transition-all duration-250 outline-none focus:border-[#1a9488] focus:shadow-[0_0_0_3px_rgba(26,148,136,0.12)] focus:bg-white <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-[#e74c3c] <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        placeholder="Masukkan password"
                        required
                        autocomplete="current-password"
                    >
                    <button type="button" class="absolute right-[14px] top-1/2 -translate-y-1/2 bg-transparent border-none cursor-pointer text-[#aaa] p-0 flex items-center transition-colors duration-200 hover:text-[#1a9488]" onclick="togglePassword()" id="toggleBtn" aria-label="Tampilkan/sembunyikan password">
                        <!-- Eye-off (default) -->
                        <svg id="icon-eye-off" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="block">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                            <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                            <line x1="1" y1="1" x2="23" y2="23"/>
                        </svg>
                        <!-- Eye (hidden) -->
                        <svg id="icon-eye" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="hidden">
                            <path d="M1 12S5 4 12 4s11 8 11 8-4 8-11 8S1 12 1 12z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="text-[0.78rem] text-[#e74c3c] mt-[5px]"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Remember me -->
            <div class="flex items-center gap-2 mb-7">
                <input type="checkbox" id="remember" name="remember" class="w-[17px] h-[17px] accent-[#1a9488] cursor-pointer rounded" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                <label for="remember" class="text-[0.85rem] text-[#666] cursor-pointer select-none">Ingat saya</label>
            </div>

            <div class="flex items-center justify-between mb-7">
                <a href="<?php echo e(route('password.request')); ?>" class="text-[0.85rem] text-[#1a9488] hover:text-[#14b8a6] hover:underline transition-colors duration-200">Lupa Password?</a>
            </div>

            <button type="submit" class="w-full py-[14px] bg-gradient-to-br from-[#1a9488] to-[#14b8a6] text-white border-none rounded-xl text-[0.95rem] font-semibold font-sans cursor-pointer tracking-[0.3px] transition-all duration-150 ease-out shadow-[0_4px_18px_rgba(26,148,136,0.35)] hover:-translate-y-0.5 hover:shadow-[0_8px_24px_rgba(26,148,136,0.45)] hover:brightness-105 active:translate-y-0">Login</button>
        </form>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function togglePassword() {
        const input   = document.getElementById('password');
        const eyeOff  = document.getElementById('icon-eye-off');
        const eyeOn   = document.getElementById('icon-eye');

        if (input.type === 'password') {
            input.type = 'text';
            eyeOff.classList.remove('block');
            eyeOff.classList.add('hidden');
            eyeOn.classList.remove('hidden');
            eyeOn.classList.add('block');
        } else {
            input.type = 'password';
            eyeOff.classList.remove('hidden');
            eyeOff.classList.add('block');
            eyeOn.classList.remove('block');
            eyeOn.classList.add('hidden');
        }
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/bimbinganKonselingNanda/resources/views/auth/login.blade.php ENDPATH**/ ?>