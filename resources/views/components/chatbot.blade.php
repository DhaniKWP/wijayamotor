<div x-data="chatbot()" class="relative font-sans" @click.away="isOpen = false">
    
    <!-- Chat Button (Pill Design) -->
    <button 
        id="wira-ai-trigger"
        @click="toggleChat" 
        class="flex items-center justify-center gap-2 bg-white border border-gray-200 md:px-4 px-2 md:py-2.5 py-1.5 rounded-full shadow-xl hover:shadow-2xl hover:scale-105 transition-all group relative z-10"
        :class="isOpen ? 'bg-slate-50' : 'bg-white'"
    >
        <span class="font-bold md:text-sm text-xs text-ink group-hover:text-brand transition hidden sm:inline whitespace-nowrap">Tanya Wira AI</span>
        <div class="md:w-[60px] md:h-[60px] w-[44px] h-[44px] bg-brand rounded-full flex items-center justify-center text-white shadow-inner relative shrink-0">
            <!-- Sparkles/AI Icon -->
            <svg class="md:w-8 md:h-8 w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M11.608 22.404a1.442 1.442 0 01-1.216 0c-.394-.183-5.59-2.716-6.195-8.47-.076-.723-.114-1.464-.114-2.222V5.13a1.441 1.441 0 01.954-1.357c3.159-1.042 6.13-2.19 6.845-2.47a1.439 1.439 0 011.036 0c.715.28 3.686 1.428 6.845 2.47a1.441 1.441 0 01.954 1.357v6.582c0 .758-.038 1.499-.114 2.222-.605 5.754-5.801 8.287-6.195 8.47zM11 16l6-6-1.414-1.414L11 13.172l-2.586-2.586L7 12l4 4z"/></svg>
            <span class="absolute top-0 right-0 flex md:h-3.5 md:w-3.5 h-3 w-3" x-show="!isOpen">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full md:h-3.5 md:w-3.5 h-3 w-3 bg-red-500 border-2 border-white"></span>
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
        class="fixed inset-x-4 bottom-24 sm:absolute sm:inset-x-auto sm:bottom-full sm:right-0 sm:mb-4 w-auto sm:w-[350px] bg-white rounded-2xl shadow-2xl flex flex-col overflow-hidden border border-gray-100 z-20"
        style="height: 500px; max-height: calc(100vh - 10rem);"
        x-cloak
    >
        <!-- Header -->
        <div class="bg-gradient-to-r from-brand to-red-600 p-4 text-white flex justify-between items-center shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                    </svg>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h3 class="font-extrabold text-sm leading-none tracking-wide">WIRA</h3>
                        <span class="bg-white/20 text-[9px] font-bold px-1.5 py-0.5 rounded-md uppercase tracking-wider">AI</span>
                    </div>
                    <div class="flex items-center gap-1.5 mt-1">
                        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                        <p class="text-[11px] text-red-100 font-medium">Online · Asisten Wijaya Motor</p>
                    </div>
                </div>
            </div>
            <button @click="toggleChat" class="text-white/70 hover:text-white hover:bg-white/10 rounded-lg p-1.5 transition relative z-10">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Chat History -->
        <div class="flex-1 overflow-y-auto p-4 space-y-4" id="chatbot-messages" style="background: linear-gradient(180deg, #fef2f2 0%, #fff5f5 30%, #fafafa 100%);">
            
            <!-- Welcome Message -->
            <div class="flex items-end gap-2">
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-red-600 to-red-700 flex items-center justify-center shrink-0 shadow-sm">
                    <svg class="w-4.5 h-4.5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a2 2 0 012 2c0 .74-.4 1.39-1 1.73V7h1a7 7 0 017 7h1a1 1 0 011 1v3a1 1 0 01-1 1h-1.07A7 7 0 0113 21h-2a7 7 0 01-6.93-6H3a1 1 0 01-1-1v-3a1 1 0 011-1h1a7 7 0 017-7h1V5.73c-.6-.34-1-.99-1-1.73a2 2 0 012-2zm-1 9H9v2h2v-2zm4 0h-2v2h2v-2zm-5 4v1a1 1 0 001 1h2a1 1 0 001-1v-1h-4z"/></svg>
                </div>
                <div class="bg-white p-3.5 rounded-2xl rounded-bl-md shadow-sm border border-red-100/60 text-[13px] text-gray-700 max-w-[82%] leading-relaxed">
                    Halo Bos! 👋 Saya <strong>Wira</strong>, Asisten AI Wijaya Motor 🔧. Ada yang bisa saya bantu soal servis atau suku cadang hari ini?
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="flex flex-wrap gap-2 pl-10">
                <button @click="input = 'Berapa biaya servis berkala?'; sendMessage()" class="text-[11px] font-semibold bg-white border border-red-200 text-red-600 px-3 py-1.5 rounded-full hover:bg-red-50 transition shadow-sm">🔧 Biaya Servis</button>
                <button @click="input = 'Ada sparepart apa aja?'; sendMessage()" class="text-[11px] font-semibold bg-white border border-red-200 text-red-600 px-3 py-1.5 rounded-full hover:bg-red-50 transition shadow-sm">🛒 Sparepart</button>
                <button @click="input = 'Cara booking servis gimana?'; sendMessage()" class="text-[11px] font-semibold bg-white border border-red-200 text-red-600 px-3 py-1.5 rounded-full hover:bg-red-50 transition shadow-sm">📅 Booking</button>
            </div>

            <!-- Dynamic Messages -->
            <template x-for="(msg, index) in messages" :key="index">
                <div class="flex items-end gap-2" :class="msg.role === 'user' ? 'flex-row-reverse' : ''">
                    <!-- Wira Avatar -->
                    <div x-show="msg.role === 'assistant'" class="w-8 h-8 rounded-full bg-gradient-to-br from-red-600 to-red-700 flex items-center justify-center shrink-0 shadow-sm">
                        <svg class="w-4.5 h-4.5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a2 2 0 012 2c0 .74-.4 1.39-1 1.73V7h1a7 7 0 017 7h1a1 1 0 011 1v3a1 1 0 01-1 1h-1.07A7 7 0 0113 21h-2a7 7 0 01-6.93-6H3a1 1 0 01-1-1v-3a1 1 0 011-1h1a7 7 0 017-7h1V5.73c-.6-.34-1-.99-1-1.73a2 2 0 012-2zm-1 9H9v2h2v-2zm4 0h-2v2h2v-2zm-5 4v1a1 1 0 001 1h2a1 1 0 001-1v-1h-4z"/></svg>
                    </div>
                    <div 
                        class="p-3.5 text-[13px] max-w-[82%] whitespace-pre-wrap leading-relaxed"
                        :class="msg.role === 'user' 
                            ? 'bg-gradient-to-br from-red-600 to-red-700 text-white rounded-2xl rounded-br-md shadow-sm' 
                            : 'bg-white text-gray-700 rounded-2xl rounded-bl-md shadow-sm border border-red-100/60'"
                        x-html="formatMessage(msg.content)"
                    ></div>
                </div>
            </template>

            <!-- Typing Indicator -->
            <div x-show="isLoading" class="flex items-end gap-2">
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-red-600 to-red-700 flex items-center justify-center shrink-0 shadow-sm">
                    <svg class="w-4.5 h-4.5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a2 2 0 012 2c0 .74-.4 1.39-1 1.73V7h1a7 7 0 017 7h1a1 1 0 011 1v3a1 1 0 01-1 1h-1.07A7 7 0 0113 21h-2a7 7 0 01-6.93-6H3a1 1 0 01-1-1v-3a1 1 0 011-1h1a7 7 0 017-7h1V5.73c-.6-.34-1-.99-1-1.73a2 2 0 012-2zm-1 9H9v2h2v-2zm4 0h-2v2h2v-2zm-5 4v1a1 1 0 001 1h2a1 1 0 001-1v-1h-4z"/></svg>
                </div>
                <div class="bg-white p-4 rounded-2xl rounded-bl-md shadow-sm border border-red-100/60 flex items-center gap-1.5">
                    <div class="w-2 h-2 bg-red-400 rounded-full animate-bounce" style="animation-delay: 0ms"></div>
                    <div class="w-2 h-2 bg-red-400 rounded-full animate-bounce" style="animation-delay: 150ms"></div>
                    <div class="w-2 h-2 bg-red-400 rounded-full animate-bounce" style="animation-delay: 300ms"></div>
                </div>
            </div>
        </div>

        <!-- Input Area -->
        <div class="bg-white p-3 border-t border-gray-100 shrink-0">
            <form @submit.prevent="sendMessage" class="flex items-center gap-2">
                <input 
                    type="text" 
                    x-model="input" 
                    placeholder="Tanya harga oli, biaya servis..." 
                    class="flex-1 bg-gray-50 border border-gray-200 focus:border-red-400 focus:ring-1 focus:ring-red-200 rounded-full px-4 py-2.5 text-sm transition placeholder:text-gray-400"
                    :disabled="isLoading"
                    required
                >
                <button 
                    type="submit" 
                    class="w-10 h-10 rounded-full bg-red-600 text-white flex items-center justify-center shrink-0 hover:bg-red-700 transition disabled:opacity-50 disabled:cursor-not-allowed shadow-sm"
                    :disabled="isLoading || input.trim() === ''"
                >
                    <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                    </svg>
                </button>
            </form>
            <div class="flex items-center justify-center gap-1 mt-2">
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
