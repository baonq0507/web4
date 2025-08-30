require('dotenv').config();
const WebSocket = require('ws');
const db = require('../../config/database');
const cron = require('node-cron');

const wss = new WebSocket.Server({ port: 8080 });
// Store active connections
const clients = new Map();

wss.on('connection', (ws) => {
    console.log('New client connected');

    ws.on('message', async (message) => {
        try {
            const data = JSON.parse(message);

            if (data.type === 'subscribe_trades') {
                // Store client with their user_id and is_admin flag
                clients.set(ws, {
                    user_id: data.user_id,
                    is_admin: data.is_admin
                });
            }
        } catch (error) {
            console.error('Error processing message:', error);
        }
    });

    ws.on('close', () => {
        clients.delete(ws);
        console.log('Client disconnected');
    });
});



const rewardGameBet = async (gameBet, callback) => {
    try {
        const [gameTime] = await db.query(`SELECT * FROM game_times WHERE id = ?`, [gameBet.game_time_id]);
        const [user] = await db.query(`SELECT * FROM portal_customers WHERE id = ?`, [gameBet.user_id]);

        if (!gameTime.length || !user.length) {
            console.log('Không tìm thấy gameTime hoặc user');
            return;
        }

        const ratio = gameTime[0].ratio;
        let reward = (gameBet.amount * ratio) / 100;
        reward = parseFloat(reward.toFixed(2));

        let balance = parseFloat(user[0].cus_balance);

        if (gameBet.bet == gameBet.result) {
            balance += gameBet.amount + reward;
        } else {
            balance += gameBet.amount - reward;
        }

        balance = parseFloat(balance.toFixed(2));

        await db.query(`UPDATE portal_customers SET cus_balance = ? WHERE id = ?`, [balance, gameBet.user_id]);
        await db.query(`UPDATE game_bets SET reward = ? WHERE id = ?`, [reward, gameBet.bet_id]);

        console.log('trả thưởng', gameBet.user_id, reward);

        if (callback) {
            callback(gameBet, reward, user[0]);
        }
    } catch (error) {
        console.error('Lỗi trong rewardGameBet:', error);
    }
};


// Broadcast trade updates to relevant clients

// Schedule cron job to update trades every second
cron.schedule('* * * * * *', async () => {
    try {
        rewardGameBet();
    } catch (error) {
        console.error('Error in cron job:', error);
    }
});

