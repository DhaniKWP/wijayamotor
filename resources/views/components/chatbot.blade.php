<div x-data="chatbot()" class="relative font-sans" @click.away="isOpen = false">
    
    <!-- Chat Button (Pill Design) -->
    <button 
        id="wira-ai-trigger"
        @click="toggleChat" 
        class="flex items-center justify-center gap-2.5 bg-white border border-gray-200 md:px-4 px-3 md:py-2.5 py-2 rounded-full shadow-xl hover:shadow-2xl hover:scale-105 transition-all group relative z-10"
        :class="isOpen ? 'ring-2 ring-red-200 bg-red-50' : 'bg-white'"
    >
        <span class="font-bold md:text-sm text-xs text-gray-800 group-hover:text-red-600 transition hidden sm:inline whitespace-nowrap">Tanya Wira AI</span>
        <div class="md:w-12 md:h-12 w-10 h-10 bg-gradient-to-br from-red-500 to-red-700 rounded-full flex items-center justify-center text-white shadow-md relative shrink-0">
            <!-- AI Robot Icon -->
            <svg class="md:w-7 md:h-7 w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a2 2 0 012 2c0 .74-.4 1.39-1 1.73V7h1a7 7 0 017 7h1a1 1 0 011 1v3a1 1 0 01-1 1h-1.07A7 7 0 0113 21h-2a7 7 0 01-6.93-6H3a1 1 0 01-1-1v-3a1 1 0 011-1h1a7 7 0 017-7h1V5.73c-.6-.34-1-.99-1-1.73a2 2 0 012-2zm-1 9H9v2h2v-2zm4 0h-2v2h2v-2zm-5 4v1a1 1 0 001 1h2a1 1 0 001-1v-1h-4z"/></svg>
            <span class="absolute -top-0.5 -right-0.5 flex h-3.5 w-3.5" x-show="!isOpen">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3.5 w-3.5 bg-green-500 border-2 border-white"></span>
            </span>
        </div>
    </button>

    <!-- Chat Window -->
    <div 
        x-show="isOpen" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 scale-95"
        class="fixed inset-x-4 bottom-24 sm:absolute sm:inset-x-auto sm:bottom-full sm:right-0 sm:mb-4 w-auto sm:w-[380px] bg-white rounded-2xl shadow-2xl flex flex-col overflow-hidden border border-gray-200/80 z-20"
        style="height: 520px; max-height: calc(100vh - 10rem);"
        x-cloak
    >
        <!-- Header -->
        <div class="relative p-4 text-white flex justify-between items-center shrink-0 overflow-hidden" style="background: linear-gradient(135deg, #b91c1c 0%, #dc2626 50%, #ef4444 100%);">
            <!-- Decorative circles -->
            <div class="absolute -top-6 -left-6 w-24 h-24 bg-white/5 rounded-full"></div>
            <div class="absolute -bottom-8 -right-4 w-20 h-20 bg-white/5 rounded-full"></div>
            
            <div class="flex items-center gap-3 relative z-10">
                <!-- AI Avatar -->
                <div class="w-11 h-11 rounded-xl bg-white/15 backdrop-blur-sm border border-white/20 flex items-center justify-center shrink-0 shadow-inner">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a2 2 0 012 2c0 .74-.4 1.39-1 1.73V7h1a7 7 0 017 7h1a1 1 0 011 1v3a1 1 0 01-1 1h-1.07A7 7 0 0113 21h-2a7 7 0 01-6.93-6H3a1 1 0 01-1-1v-3a1 1 0 011-1h1a7 7 0 017-7h1V5.73c-.6-.34-1-.99-1-1.73a2 2 0 012-2zm-1 9H9v2h2v-2zm4 0h-2v2h2v-2zm-5 4v1a1 1 0 001 1h2a1 1 0 001-1v-1h-4z"/></svg>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h3 class="font-extrabold text-[15px] leading-none tracking-wide">WIRA</h3>
                        <span class="bg-white/20 backdrop-blur-sm text-[9px] font-bold px-1.5 py-0.5 rounded uppercase tracking-wider">AI</span>
                    </div>
                    <div class="flex items-center gap-1.5 mt-1.5">
                        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse shadow-sm shadow-green-400/50"></span>
                        <p class="text-[11px] text-red-100 font-medium">Online · Asisten Wijaya Motor</p>
                    </div>
                </div>
            </div>
            <button @click="toggleChat" class="relative z-10 text-white/60 hover:text-white hover:bg-white/10 rounded-lg p-1.5 transition">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Chat History -->
        <div class="flex-1 overflow-y-auto p-4 space-y-4" id="chatbot-messages" style="background: linear-gradient(180deg, #fef2f2 0%, #fafafa 100%);">
            
            <!-- Welcome Message -->
            <div class="flex items-end gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-red-600 to-red-700 flex items-center justify-center shrink-0 shadow-sm">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a2 2 0 012 2c0 .74-.4 1.39-1 1.73V7h1a7 7 0 017 7h1a1 1 0 011 1v3a1 1 0 01-1 1h-1.07A7 7 0 0113 21h-2a7 7 0 01-6.93-6H3a1 1 0 01-1-1v-3a1 1 0 011-1h1a7 7 0 017-7h1V5.73c-.6-.34-1-.99-1-1.73a2 2 0 012-2zm-1 9H9v2h2v-2zm4 0h-2v2h2v-2zm-5 4v1a1 1 0 001 1h2a1 1 0 001-1v-1h-4z"/></svg>
                </div>
                <div class="bg-white p-3.5 rounded-2xl rounded-bl-sm shadow-sm border border-gray-100 text-[13px] text-gray-700 max-w-[82%] leading-relaxed">
                    Halo Bos! 👋 Saya <strong>Wira</strong>, Asisten AI Wijaya Motor.<br><br>Mau tanya soal harga servis, sparepart, atau booking? Langsung aja klik tombol di bawah atau ketik pertanyaannya ya! 🔧
                </div>
            </div>

            <!-- Quick Action Buttons (FAQ Recommendations) -->
            <div x-show="messages.length === 0" class="space-y-2 pl-[42px]">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Pertanyaan Populer 🔥</p>
                <div class="flex flex-wrap gap-1.5">
                    <button @click="quickAsk('Berapa biaya jasa servis berkala?')" class="text-[11px] font-semibold bg-white border border-red-200/80 text-red-600 px-3 py-2 rounded-xl hover:bg-red-50 hover:border-red-300 transition shadow-sm flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17l-5.384-3.065A2 2 0 015 10.268V5a2 2 0 012-2h10a2 2 0 012 2v5.268a2 2 0 01-1.036 1.837l-5.384 3.065a2 2 0 01-2.16 0z"/></svg>
                        Biaya Servis Berkala
                    </button>
                    <button @click="quickAsk('Harga ganti oli berapa ya?')" class="text-[11px] font-semibold bg-white border border-red-200/80 text-red-600 px-3 py-2 rounded-xl hover:bg-red-50 hover:border-red-300 transition shadow-sm flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                        Harga Ganti Oli
                    </button>
                    <button @click="quickAsk('Ada sparepart apa aja yang tersedia?')" class="text-[11px] font-semibold bg-white border border-red-200/80 text-red-600 px-3 py-2 rounded-xl hover:bg-red-50 hover:border-red-300 transition shadow-sm flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        Daftar Sparepart
                    </button>
                    <button @click="quickAsk('Gimana cara booking servis di website?')" class="text-[11px] font-semibold bg-white border border-red-200/80 text-red-600 px-3 py-2 rounded-xl hover:bg-red-50 hover:border-red-300 transition shadow-sm flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Cara Booking
                    </button>
                    <button @click="quickAsk('Bengkel buka jam berapa dan tutup jam berapa?')" class="text-[11px] font-semibold bg-white border border-red-200/80 text-red-600 px-3 py-2 rounded-xl hover:bg-red-50 hover:border-red-300 transition shadow-sm flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Jam Operasional
                    </button>
                    <button @click="quickAsk('Harga tune up mesin berapa?')" class="text-[11px] font-semibold bg-white border border-red-200/80 text-red-600 px-3 py-2 rounded-xl hover:bg-red-50 hover:border-red-300 transition shadow-sm flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Harga Tune Up
                    </button>
                </div>
            </div>

            <!-- Dynamic Messages -->
            <template x-for="(msg, index) in messages" :key="index">
                <div class="flex items-end gap-2.5" :class="msg.role === 'user' ? 'flex-row-reverse' : ''">
                    <!-- Wira Avatar -->
                    <div x-show="msg.role === 'assistant'" class="w-8 h-8 rounded-lg bg-gradient-to-br from-red-600 to-red-700 flex items-center justify-center shrink-0 shadow-sm">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a2 2 0 012 2c0 .74-.4 1.39-1 1.73V7h1a7 7 0 017 7h1a1 1 0 011 1v3a1 1 0 01-1 1h-1.07A7 7 0 0113 21h-2a7 7 0 01-6.93-6H3a1 1 0 01-1-1v-3a1 1 0 011-1h1a7 7 0 017-7h1V5.73c-.6-.34-1-.99-1-1.73a2 2 0 012-2zm-1 9H9v2h2v-2zm4 0h-2v2h2v-2zm-5 4v1a1 1 0 001 1h2a1 1 0 001-1v-1h-4z"/></svg>
                    </div>
                    <div 
                        class="p-3.5 text-[13px] max-w-[82%] whitespace-pre-wrap leading-relaxed"
                        :class="msg.role === 'user' 
                            ? 'bg-gradient-to-br from-red-600 to-red-700 text-white rounded-2xl rounded-br-sm shadow-sm' 
                            : 'bg-white text-gray-700 rounded-2xl rounded-bl-sm shadow-sm border border-gray-100'"
                        x-html="formatMessage(msg.content)"
                    ></div>
                </div>
            </template>

            <!-- Typing Indicator -->
            <div x-show="isLoading" class="flex items-end gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-red-600 to-red-700 flex items-center justify-center shrink-0 shadow-sm">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a2 2 0 012 2c0 .74-.4 1.39-1 1.73V7h1a7 7 0 017 7h1a1 1 0 011 1v3a1 1 0 01-1 1h-1.07A7 7 0 0113 21h-2a7 7 0 01-6.93-6H3a1 1 0 01-1-1v-3a1 1 0 011-1h1a7 7 0 017-7h1V5.73c-.6-.34-1-.99-1-1.73a2 2 0 012-2zm-1 9H9v2h2v-2zm4 0h-2v2h2v-2zm-5 4v1a1 1 0 001 1h2a1 1 0 001-1v-1h-4z"/></svg>
                </div>
                <div class="bg-white p-4 rounded-2xl rounded-bl-sm shadow-sm border border-gray-100 flex items-center gap-2">
                    <div class="w-2 h-2 bg-red-400 rounded-full animate-bounce" style="animation-delay: 0ms"></div>
                    <div class="w-2 h-2 bg-red-400 rounded-full animate-bounce" style="animation-delay: 150ms"></div>
                    <div class="w-2 h-2 bg-red-400 rounded-full animate-bounce" style="animation-delay: 300ms"></div>
                    <span class="text-[10px] text-gray-400 ml-1">Wira mengetik...</span>
                </div>
            </div>
        </div>

        <!-- Input Area -->
        <div class="bg-white px-3 pt-3 pb-2.5 border-t border-gray-100 shrink-0">
            <form @submit.prevent="sendMessage" class="flex items-center gap-2">
                <input 
                    type="text" 
                    x-model="input" 
                    placeholder="Ketik pertanyaan kamu di sini..." 
                    class="flex-1 bg-gray-50 border border-gray-200 focus:border-red-400 focus:ring-1 focus:ring-red-100 rounded-full px-4 py-2.5 text-sm transition placeholder:text-gray-400"
                    :disabled="isLoading"
                    required
                >
                <button 
                    type="submit" 
                    class="w-10 h-10 rounded-full bg-gradient-to-br from-red-500 to-red-700 text-white flex items-center justify-center shrink-0 hover:from-red-600 hover:to-red-800 transition-all disabled:opacity-40 disabled:cursor-not-allowed shadow-md hover:shadow-lg"
                    :disabled="isLoading || input.trim() === ''"
                >
                    <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                    </svg>
                </button>
            </form>
            <div class="flex items-center justify-center gap-1.5 mt-2">
                <svg class="w-3 h-3 text-red-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a2 2 0 012 2c0 .74-.4 1.39-1 1.73V7h1a7 7 0 017 7h1a1 1 0 011 1v3a1 1 0 01-1 1h-1.07A7 7 0 0113 21h-2a7 7 0 01-6.93-6H3a1 1 0 01-1-1v-3a1 1 0 011-1h1a7 7 0 017-7h1V5.73c-.6-.34-1-.99-1-1.73a2 2 0 012-2zm-1 9H9v2h2v-2zm4 0h-2v2h2v-2zm-5 4v1a1 1 0 001 1h2a1 1 0 001-1v-1h-4z"/></svg>
                <span class="text-[10px] text-gray-400 font-medium">Wira AI · Harga bersifat estimasi jasa</span>
            </div>
        </div>
    </div>
</div>

<script>
function chatbot() {
    return {
        isOpen: false,
        input: '',
        isLoading: false,
        messages: [],
        
        toggleChat() {
            this.isOpen = !this.isOpen;
            if (this.isOpen) {
                setTimeout(() => {
                    this.scrollToBottom();
                }, 300);
            }
        },

        scrollToBottom() {
            const container = document.getElementById('chatbot-messages');
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        },

        formatMessage(text) {
            let formatted = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
            return formatted;
        },

        quickAsk(question) {
            this.input = question;
            this.sendMessage();
        },

        async sendMessage() {
            if (this.input.trim() === '') return;
            
            const userMsg = this.input.trim();
            this.input = '';
            
            this.messages.push({ role: 'user', content: userMsg });
            this.isLoading = true;
            
            setTimeout(() => this.scrollToBottom(), 50);

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                
                const response = await fetch('/chatbot/chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        message: userMsg,
                        history: this.messages.slice(-5)
                    })
                });

                const data = await response.json();
                
                if (data.reply) {
                    this.messages.push({ role: 'assistant', content: data.reply });
                } else {
                    this.messages.push({ role: 'assistant', content: 'Maaf Kak, Wira lagi ada kendala jaringan nih.' });
                }
            } catch (error) {
                console.error('Chatbot error:', error);
                this.messages.push({ role: 'assistant', content: 'Waduh, koneksi ke server terputus Kak. Mohon coba lagi ya 🙏' });
            } finally {
                this.isLoading = false;
                setTimeout(() => this.scrollToBottom(), 50);
            }
        }
    }
}
</script>
