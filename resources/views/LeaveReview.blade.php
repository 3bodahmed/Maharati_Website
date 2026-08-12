<!doctype html>
<html lang="ar">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="AppStyles.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css" /> 
    <title>تقييم الخدمة - مهارتي</title>
    <link rel="icon" href="Logo.png" />
</head>
<body>
    <header class="navbar"><!-- نفس النافبار --></header>

    <main class="dashboard-container" style="max-width:700px; margin:0 auto;">
        <div class="page-header"><h1>تقييم <span>الخدمة</span></h1></div>

        <div style="text-align:center; margin-bottom:20px;">
            <img src="https://i.pravatar.cc/80?img=1" style="width:80px; height:80px; border-radius:50%; border:3px solid var(--gold);" />
            <h3 style="margin-top:10px;">أحمد النجار</h3>
            <p style="opacity:0.7;">كيف تقيم تجربتك معه؟</p>
        </div>

        <form id="reviewForm">
            <div style="text-align:center;">
                <div class="stars-container" id="stars">
                    <i class="fas fa-star" data-value="1"></i>
                    <i class="fas fa-star" data-value="2"></i>
                    <i class="fas fa-star" data-value="3"></i>
                    <i class="fas fa-star" data-value="4"></i>
                    <i class="fas fa-star" data-value="5"></i>
                </div>
                <input type="hidden" id="ratingValue" value="0" />
            </div>

            <label style="display:block; margin-top:15px; font-weight:700;">تعليقك:</label>
            <textarea id="reviewText" rows="4" placeholder="اكتب تجربتك مع مقدم الخدمة..." style="width:100%; padding:15px; background:rgba(255,255,255,0.05); border:1px solid var(--glass-border); border-radius:16px; color:#fff; font-family:var(--font-family); resize:vertical;"></textarea>

            <button type="submit" id="submitReview" style="width:100%; padding:16px; margin-top:20px; background:var(--gold); border:none; border-radius:50px; font-weight:800; font-size:1.2rem; color:#1e1e2f; cursor:pointer;">
                <span class="btn-text">إرسال التقييم</span>
                <span class="spinner" style="display:none;"></span>
            </button>
            <div id="reviewMsg" class="form-message" style="display:none; margin-top:10px;"></div>
        </form>

        <div style="margin-top:30px; padding:15px; background:rgba(255,71,87,0.1); border-radius:16px; border:1px solid var(--red); text-align:center; color:var(--red); font-weight:700;">
            <i class="fas fa-lock"></i> يمكنك تقييم هذا الطلب مرة واحدة فقط.
        </div>
    </main>

    <script>
        // نجوم التقييم
        const stars = document.querySelectorAll('.stars-container i');
        const ratingInput = document.getElementById('ratingValue');
        stars.forEach(star => {
            star.addEventListener('click', function() {
                const val = parseInt(this.dataset.value);
                ratingInput.value = val;
                stars.forEach(s => s.classList.remove('active'));
                for (let i = 0; i < val; i++) stars[i].classList.add('active');
            });
        });

        // إرسال التقييم مع Spinner
        document.getElementById('reviewForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = document.getElementById('submitReview');
            const text = btn.querySelector('.btn-text');
            const spin = btn.querySelector('.spinner');
            const msg = document.getElementById('reviewMsg');
            const rating = parseInt(ratingInput.value);
            const comment = document.getElementById('reviewText').value.trim();

            if(rating === 0) { msg.style.display='block'; msg.className='form-message error'; msg.textContent='❌ يرجى اختيار عدد النجوم.'; return; }

            btn.disabled = true; text.style.display='none'; spin.style.display='inline-block'; msg.style.display='none';
            setTimeout(() => {
                btn.disabled = false; text.style.display='inline'; spin.style.display='none';
                msg.style.display='block'; msg.className='form-message success';
                msg.innerHTML = `✅ شكراً لتقييمك! قيمت ${rating} نجوم. سيتم توجيهك للوحة التحكم.`;
                setTimeout(() => window.location.href='ClientDashboard.html', 2000);
            }, 1500);
        });
    </script>
</body>
</html>