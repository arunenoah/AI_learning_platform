const { Client, LocalAuth } = require('whatsapp-web.js');
const qrcode = require('qrcode-terminal');
const axios  = require('axios');

// ─── Config ───────────────────────────────────────────────────────────────────
const LARAVEL_URL    = process.env.LARAVEL_URL    || 'https://lrh.on-forge.com';
const AGENT_SECRET   = process.env.AGENT_SECRET   || 'change-me';
const YOUR_NUMBER    = process.env.YOUR_NUMBER     || '';   // e.g. 919876543210 (no +)

if (!YOUR_NUMBER) {
    console.error('❌  Set YOUR_NUMBER in .env (your WhatsApp number without +)');
    process.exit(1);
}

// ─── WhatsApp Client ──────────────────────────────────────────────────────────
const client = new Client({
    authStrategy: new LocalAuth({ clientId: 'learnhub-agent' }),
    puppeteer: {
        args: [
            '--no-sandbox',
            '--disable-setuid-sandbox',
            '--disable-dev-shm-usage',
            '--disable-gpu',
        ],
    },
});

client.on('qr', qr => {
    console.log('\n📱  Scan this QR code with your WhatsApp:\n');
    qrcode.generate(qr, { small: true });
});

client.on('authenticated', () => console.log('🔑  Authenticated'));
client.on('ready',         () => console.log('✅  WhatsApp agent is ready'));
client.on('disconnected',  reason => {
    console.error('❌  Disconnected:', reason);
    process.exit(1); // PM2 will restart it
});

// ─── Message Handler ──────────────────────────────────────────────────────────
client.on('message', async msg => {
    // Only respond to your own messages
    const senderNumber = msg.from.replace('@c.us', '').replace(/\D/g, '');
    if (senderNumber !== YOUR_NUMBER.replace(/\D/g, '')) return;

    const text = msg.body.trim();

    // Extract first URL from the message
    const urlMatch = text.match(/https?:\/\/[^\s]+/);
    if (!urlMatch) {
        await msg.reply(
            '👋 *LearnHub Agent*\n\n' +
            'Send me any URL and I\'ll research it and add it to the blog.\n\n' +
            'Example:\nhttps://example.com/article-about-ai'
        );
        return;
    }

    const url = urlMatch[0];
    console.log(`📥  Received URL: ${url}`);

    await msg.reply('🔍 Researching the link...');

    try {
        const response = await axios.post(
            `${LARAVEL_URL}/api/ingest-link`,
            { url },
            {
                headers: {
                    'X-Agent-Secret': AGENT_SECRET,
                    'Content-Type':   'application/json',
                },
                timeout: 30000,
            }
        );

        const r = response.data.resource;

        await msg.reply(
            `✅ *Added to blog!*\n\n` +
            `📖 *${r.title}*\n` +
            `📂 ${r.category}  •  ${r.type}\n` +
            `⭐ Level ${r.difficulty_level}  •  ⏱ ${r.duration_minutes} min\n\n` +
            `💡 ${r.learning_reason}\n\n` +
            `🔗 ${LARAVEL_URL}/blogs`
        );

    } catch (err) {
        const status  = err.response?.status;
        const message = err.response?.data?.message || err.message;

        if (status === 409) {
            await msg.reply(`⚠️ This URL is already in the blog.`);
        } else if (status === 403) {
            await msg.reply(`🔒 Unauthorized. Check AGENT_SECRET.`);
        } else {
            console.error('Error:', message);
            await msg.reply(`❌ Failed to add resource.\n\n${message}`);
        }
    }
});

// ─── Start ────────────────────────────────────────────────────────────────────
console.log('🚀  Starting WhatsApp agent...');
client.initialize();
