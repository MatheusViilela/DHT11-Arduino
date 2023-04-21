const { SerialPort } = require('serialport')
const { ReadlineParser } = require('@serialport/parser-readline')
const mysql = require('mysql2/promise');

const port = new SerialPort({ path: 'COM3', baudRate: 9600 })
const parser = port.pipe(new ReadlineParser({ delimiter: '\n' }));

const dbConfig = {
  host: '127.0.0.1',
  user: 'root',
  password: '',
  database: 'arduino',
};

async function saveDataToDatabase(data) {
  try {
    const connection = await mysql.createConnection(dbConfig);
    const [rows, fields] = await connection.execute(
      'INSERT INTO dados (temperatura, umidade, tms_cadastro) VALUES (?, ?, NOW())',
      [data.temperature, data.humidity]
    );
    console.log(`Dados salvos no banco de dados: ${JSON.stringify(data)}`);
  } catch (error) {
    console.error(`Erro ao salvar dados no banco de dados: ${error.message}`);
  }
}

parser.on('data', async function (data) {
  console.log('Dados recebidos: ' + data);
  const [temp, temperaturaStr, unit1, umid, umidadeStr, unit2] = data.split(' ');
  const temperatura = parseFloat(temperaturaStr);
  const umidade = parseFloat(umidadeStr);
  try {
    await saveDataToDatabase({ temperature: temperatura, humidity: umidade });
  } catch (error) {
    console.error(`Erro ao salvar dados no banco de dados: ${error.message}`);
  }
});


port.on('error', function (err) {
  console.error(`Erro na porta serial: ${err.message}`);
});