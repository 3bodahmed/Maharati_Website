<!doctype html>
<html lang="ar">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="Chat.css" />
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css" /> 
    
    <title>الدردشة - مهارتي</title>
    <link rel="icon" href="Logo.png" />
</head>
<body>

    <header class="navbar">
        <div class="nav-container">
            <div class="nav-brand">
                <img src="Logo.png" alt="شعار مهارتي" class="nav-logo" />
                <h2>في <span>مهارتي</span></h2>
            </div>
            <div class="nav-actions">
                <a href="HomeClient.html" class="btn-outline"><i class="fas fa-home"></i> الرئيسية</a>
                <a href="ClientDashboard.html" class="btn-outline"><i class="fas fa-th-large"></i> لوحة التحكم</a>
                <a href="Profile.html" class="btn-outline"><i class="fas fa-user"></i> ملفي</a>
                <span class="user-greeting"><i class="fas fa-user"></i> أحمد</span>
                <img src="https://i.pravatar.cc/40?img=3" alt="صورة" class="user-avatar" />
                <a href="HomeVisitor.html" class="btn-outline logout-btn" onclick="return confirm('تسجيل الخروج؟');"><i class="fas fa-sign-out-alt"></i> خروج</a>
            </div>
        </div>
    </header>

    <main class="chat-container">

        <div class="chat-header-page">
            <h1><i class="fas fa-comments"></i> غرفة <span>المحادثات</span></h1>
            <a href="ClientDashboard.html" class="btn-back"><i class="fas fa-arrow-right"></i> العودة</a>
        </div>

        <!-- ===== تخطيط الدردشة ===== -->
        <div class="chat-layout">

            <!-- ===== الشريط الجانبي (قائمة المحادثات) ===== -->
            <div class="chat-sidebar">
                <div class="sidebar-header">
                    <span><i class="fas fa-inbox"></i> المحادثات</span>
                    <span class="unread-badge">2</span>
                </div>

                <div class="chat-user active">
                    <img src="https://i.pravatar.cc/45?img=1" alt="صورة" />
                    <div class="chat-user-info">
                        <div class="name">أحمد النجار</div>
                        <div class="last-msg">تمام، سأصل غداً...</div>
                    </div>
                    <div class="chat-time">الآن</div>
                </div>

                <div class="chat-user unread">
                    <img src="https://i.pravatar.cc/45?img=10" alt="صورة" />
                    <div class="chat-user-info">
                        <div class="name">فهد السباك</div>
                        <div class="last-msg">تم إصلاح التسريب</div>
                    </div>
                    <div class="chat-time">5د</div>
                </div>

                <div class="chat-user">
                    <img src="https://i.pravatar.cc/45?img=12" alt="صورة" />
                    <div class="chat-user-info">
                        <div class="name">سعيد الكهربائي</div>
                        <div class="last-msg">أرسل الموقع</div>
                    </div>
                    <div class="chat-time">ساعتين</div>
                </div>

                <div class="chat-user">
                    <img src="https://i.pravatar.cc/45?img=8" alt="صورة" />
                    <div class="chat-user-info">
                        <div class="name">محمد الدهان</div>
                        <div class="last-msg">تم الانتهاء من العمل</div>
                    </div>
                    <div class="chat-time">أمس</div>
                </div>

                <div class="chat-user">
                    <img src="https://i.pravatar.cc/45?img=5" alt="صورة" />
                    <div class="chat-user-info">
                        <div class="name">نورة الخياطة</div>
                        <div class="last-msg">أوكي، خلاص متفقين</div>
                    </div>
                    <div class="chat-time">3 أيام</div>
                </div>
            </div>

            <!-- ===== نافذة الدردشة ===== -->
            <div class="chat-main">

                <!-- رأس المحادثة -->
                <div class="chat-header-window">
                    <div class="chat-partner">
                        <img src="https://i.pravatar.cc/45?img=1" alt="صورة" />
                        <div>
                            <strong>أحمد النجار</strong>
                            <span><i class="fas fa-circle online"></i> متصل الآن</span>
                        </div>
                    </div>
                    <div class="chat-window-actions">
                        <button class="btn-icon" title="بحث في المحادثة"><i class="fas fa-search"></i></button>
                        <button class="btn-icon" title="خيارات"><i class="fas fa-ellipsis-v"></i></button>
                    </div>
                </div>

                <!-- منطقة الرسائل -->
                <div class="chat-messages" id="chatMessages">

                    <div class="msg-date">اليوم</div>

                    <div class="msg received">
                        <div class="msg-bubble">
                            <p>مرحباً، متى تقدر تجي تتركب المطبخ؟</p>
                            <span class="msg-time">10:30 ص</span>
                        </div>
                    </div>

                    <div class="msg sent">
                        <div class="msg-bubble">
                            <p>السلام عليكم، أقدر أجي بكرة الصباح إن شاء الله</p>
                            <span class="msg-time">10:32 ص <i class="fas fa-check-double read"></i></span>
                        </div>
                    </div>

                    <div class="msg received">
                        <div class="msg-bubble">
                            <p>تمام، ننتظرك. كم السعر النهائي؟</p>
                            <span class="msg-time">10:35 ص</span>
                        </div>
                    </div>

                    <div class="msg sent">
                        <div class="msg-bubble">
                            <p>1500 شامل المواد، متفقين؟</p>
                            <span class="msg-time">10:38 ص <i class="fas fa-check-double read"></i></span>
                        </div>
                    </div>

                    <div class="msg received">
                        <div class="msg-bubble">
                            <p>متفقين 👍</p>
                            <span class="msg-time">10:40 ص</span>
                        </div>
                    </div>

                    <div class="msg sent">
                        <div class="msg-bubble">
                            <p>بإذن الله بكرة الساعة 8 صباحاً</p>
                            <span class="msg-time">10:45 ص <i class="fas fa-check-double read"></i></span>
                        </div>
                    </div>

                    <div class="typing-indicator">
                        <span>أحمد النجار يكتب...</span>
                    </div>

                </div>

                <!-- مدخل الرسالة -->
                <div class="chat-input-area">
                    <button class="btn-attach"><i class="fas fa-paperclip"></i></button>
                    <input type="text" placeholder="اكتب رسالتك..." id="messageInput" />
                    <button class="btn-emoji"><i class="fas fa-smile"></i></button>
                    <button class="btn-send" id="sendBtn"><i class="fas fa-paper-plane"></i></button>
                </div>

            </div>
        </div>

    </main>

    <footer class="chat-footer">
        <p>© 2026 <span>مهارتي</span> - جميع الحقوق محفوظة</p>
    </footer>

    <!-- ===== السكريبت ===== -->
    <script>
        // إرسال رسالة جديدة (محاكاة)
        document.getElementById('sendBtn').addEventListener('click', function() {
            const input = document.getElementById('messageInput');
            const message = input.value.trim();
            if (!message) return;

            const messagesContainer = document.getElementById('chatMessages');

            // إنشاء رسالة جديدة
            const msgDiv = document.createElement('div');
            msgDiv.className = 'msg sent';

            const now = new Date();
            const timeStr = now.getHours().toString().padStart(2, '0') + ':' + 
                          now.getMinutes().toString().padStart(2, '0');

            msgDiv.innerHTML = `
                <div class="msg-bubble">
                    <p>${message}</p>
                    <span class="msg-time">${timeStr} <i class="fas fa-check"></i></span>
                </div>
            `;

            // إزالة مؤشر الكتابة
            const typing = document.querySelector('.typing-indicator');
            if (typing) typing.remove();

            // إضافة الرسالة
            messagesContainer.appendChild(msgDiv);

            // إظهار مؤشر الكتابة بعد 1 ثانية (محاكاة رد)
            const typingIndicator = document.createElement('div');
            typingIndicator.className = 'typing-indicator';
            typingIndicator.innerHTML = '<span>أحمد النجار يكتب...</span>';
            messagesContainer.appendChild(typingIndicator);

            // تمرير للأسفل
            messagesContainer.scrollTop = messagesContainer.scrollHeight;

            // مسح الحقل
            input.value = '';

            // محاكاة الرد بعد 2 ثانية
            setTimeout(() => {
                typingIndicator.remove();

                const replyDiv = document.createElement('div');
                replyDiv.className = 'msg received';
                const replyTime = new Date();
                const replyTimeStr = replyTime.getHours().toString().padStart(2, '0') + ':' + 
                                    replyTime.getMinutes().toString().padStart(2, '0');

                const replies = [
                    'تمام، خلاص متفقين',
                    'بإذن الله أكون موجود',
                    'شكراً لك، نراكم غداً',
                    'أوكي، تم الاستلام',
                    'أنا في الطريق الآن'
                ];
                const randomReply = replies[Math.floor(Math.random() * replies.length)];

                replyDiv.innerHTML = `
                    <div class="msg-bubble">
                        <p>${randomReply}</p>
                        <span class="msg-time">${replyTimeStr}</span>
                    </div>
                `;
                messagesContainer.appendChild(replyDiv);
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }, 2000);
        });

        // إرسال بالضغط على Enter
        document.getElementById('messageInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('sendBtn').click();
            }
        });
    </script>

</body>
</html>