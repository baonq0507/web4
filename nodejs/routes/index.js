var express = require('express');
var router = express.Router();

/* GET home page. */
router.get('/binance/:symbol', async (req, res) => {
  const symbol = req.params.symbol;
  // get symbolid
  // const [symbolId] = await db.query(`SELECT id FROM symbols WHERE symbol = '${symbol}'`);
  const url = `https://api.binance.com/api/v3/klines?symbol=${symbol}&interval=1m&limit=1000`;
  const response = await fetch(url);
  const data = await response.json()

  res.json(data);
});

router.get('/binance/depth/:symbol', async (req, res) => {
  const symbol = req.params.symbol;
  const url = `https://api.binance.com/api/v3/depth?symbol=${symbol}&limit=5`;
  const response = await fetch(url);
  const data = await response.json()
  res.json(data);
});
module.exports = router;
