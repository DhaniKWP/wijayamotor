<div x-data="chatbot()" class="relative font-sans" @click.away="isOpen = false">
    
    <!-- Chat Button (Pill Design) -->
    <button 
        @click="toggleChat" 
        class="flex items-center gap-3 bg-white border border-gray-200 px-4 py-2.5 rounded-full shadow-xl hover:shadow-2xl hover:scale-105 transition-all group relative z-10"
        :class="isOpen ? 'bg-slate-50' : 'bg-white'"
    >
        <span class="font-bold text-sm text-ink group-hover:text-brand transition">Tanya Wira AI</span>
        <div class="w-10 h-10 bg-brand rounded-full flex items-center justify-center text-white shadow-inner relative">
            <!-- Sparkles/AI Icon -->
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M11.608 22.404a1.442 1.442 0 01-1.216 0c-.394-.183-5.59-2.716-6.195-8.47-.076-.723-.114-1.464-.114-2.222V5.13a1.441 1.441 0 01.954-1.357c3.159-1.042 6.13-2.19 6.845-2.47a1.439 1.439 0 011.036 0c.715.28 3.686 1.428 6.845 2.47a1.441 1.441 0 01.954 1.357v6.582c0 .758-.038 1.499-.114 2.222-.605 5.754-5.801 8.287-6.195 8.47zM11 16l6-6-1.414-1.414L11 13.172l-2.586-2.586L7 12l4 4z"/></svg>
            <span class="absolute top-0 right-0 flex h-3.5 w-3.5" x-show="!isOpen">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3.5 w-3.5 bg-red-500 border-2 border-white"></span>
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
        class="absolute bottom-full right-0 mb-4 w-[350px] max-w-[calc(100vw-3rem)] bg-white rounded-2xl shadow-2xl flex flex-col overflow-hidden border border-gray-100 origin-bottom-right z-20"
        style="height: 500px; max-height: calc(100vh - 6rem);"
        x-cloak
    >
        <!-- Header -->
        <div class="bg-gradient-to-r from-brand to-red-600 p-4 text-white flex justify-between items-center shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-sm leading-none">WIRA</h3>
                    <p class="text-xs text-red-100 mt-1">Asisten Wijaya Motor</p>
                </div>
            </div>
            <button @click="toggleChat" class="text-white/80 hover:text-white transition">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Chat History -->
        <div class="flex-1 overflow-y-auto p-4 bg-slate-50 space-y-4" id="chatbot-messages">
            <!-- Welcome Message -->
            <div class="flex items-start gap-2.5">
                <div class="w-8 h-8 rounded-full bg-brand flex items-center justify-center shrink-0">
                    <span class="text-white text-xs font-bold">W</span>
                </div>
                <div class="bg-white p-3 rounded-2xl rounded-tl-none shadow-sm border border-gray-100 text-sm text-gray-700 max-w-[85%] whitespace-pre-wrap">Halo Bosku! Saya Wira, Asisten Virtual Wijaya Motor 🤖. Ada yang bisa saya bantu soal servis atau suku cadang hari ini?</div>
            </div>

            <!-- Dynamic Messages -->
            <template x-for="(msg, index) in messages" :key="index">
                <div class="flex items-start gap-2.5" :class="msg.role === 'user' ? 'flex-row-reverse' : ''">
                    <div x-show="msg.role === 'assistant'" class="w-8 h-8 rounded-full bg-brand flex items-center justify-center shrink-0">
                        <span class="text-white text-xs font-bold">W</span>
                    </div>
                    <div 
                        class="p-3 shadow-sm border text-sm max-w-[85%] whitespace-pre-wrap"
                        :class="msg.role === 'user' 
                            ? 'bg-slate-800 text-white rounded-2xl rounded-tr-none border-slate-700' 
                            : 'bg-white text-gray-700 rounded-2xl rounded-tl-none border-gray-100'"
                        x-html="formatMessage(msg.content)"
                    ></div>
                </div>
            </template>

            <!-- Typing Indicator -->
            <div x-show="isLoading" class="flex items-start gap-2.5">
                <div class="w-8 h-8 rounded-full bg-brand flex items-center justify-center shrink-0">
                    <span class="text-white text-xs font-bold">W</span>
                </div>
                <div class="bg-white p-4 rounded-2xl rounded-tl-none shadow-sm border border-gray-100 flex items-center gap-1.5 w-16 h-10">
                    <div class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0ms"></div>
                    <div class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 150ms"></div>
                    <div class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 300ms"></div>
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
                    class="flex-1 bg-slate-50 border-transparent focus:border-brand focus:ring-0 rounded-full px-4 py-2 text-sm transition"
                    :disabled="isLoading"
                    required
                >
                <button 
                    type="submit" 
                    class="w-10 h-10 rounded-full bg-brand text-white flex items-center justify-center shrink-0 hover:bg-brand-dark transition disabled:opacity-50 disabled:cursor-not-allowed"
                    :disabled="isLoading || input.trim() === ''"
                >
                    <svg class="w-4 h-4 transform rotate-90 ml-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                </button>
            </form>
            <div class="text-[10px] text-center text-gray-400 mt-2">Powered by AI - Harga bersifat estimasi</div>
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
                    document.querySelector('#chatbot-messages input')?.focus();
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
            // Simple markdown parsing for bold and linebreaks
            let formatted = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
            return formatted;
        },

        async sendMessage() {
            if (this.input.trim() === '') return;
            
            const userMsg = this.input.trim();
            this.input = '';
            
            // Add to UI
            this.messages.push({ role: 'user', content: userMsg });
            this.isLoading = true;
            
            // Scroll down
            setTimeout(() => this.scrollToBottom(), 50);

            try {
                // Determine token based on standard Laravel CSRF
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
                        // We send the last 5 messages as history to maintain context
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
                this.messages.push({ role: 'assistant', content: 'Waduh, koneksi ke server terputus Kak. Mohon coba lagi ya.' });
            } finally {
                this.isLoading = false;
                setTimeout(() => this.scrollToBottom(), 50);
            }
        }
    }
}
</script>
