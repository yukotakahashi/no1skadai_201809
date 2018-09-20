<?php
    class GoogleSpread {

        const URL = 'https://sheets.googleapis.com/v4/spreadsheets/';
        const SPREAD_ID = '11BCnspCt2Mut3nhc4WMY6CYTd0zF9C3eCzsk1AEpKLM';
        const API_KEY = ''; // ここにAPIキーを入れる。

        /*
        spread sheet取得結果を返却
        */
        public function getSpreadsheetsInfo() {
            // google spread sheet apiから情報を取得
            $result = $this->getGoogleSpreadApi();
            // 必要な値を取得
            $dispData = [];
            foreach($result as $spread) {
                // 列全体の値を取得
                $allData = current(current($spread)->data)->rowData;
                $dispData = $this->convertSpreadData($allData);
            }

            return $dispData;
        }

        /*
        google spread sheet apiから結果を取得
        */
        private function getGoogleSpreadApi() {
            try {
                $baseUrl = self::URL.self::SPREAD_ID.'?';
                // queryパラメータ作成
                $query = [
                    'key' => self::API_KEY,
                    'includeGridData' => true,
                    'ranges' => 'sales!A1:E6',
                    'fields' => 'sheets.data.rowData.values(formattedValue)'
                ];
                // エラーの場合も取得可能にする
                $context = stream_context_create(
                    ['http' => [
                        'ignore_errors' => true
                    ]]
                );
    
                // 結果取得
                $result = file_get_contents($baseUrl . http_build_query($query), false, $context);
                
                // ヘッダー内容からエラー判定　※200以外はエラー
                preg_match('/HTTP\/1\.[0|1|x] ([0-9]{3})/', $http_response_header[0], $matches);
                if ($matches[1] != '200') {
                    throw new Exception('API接続中にエラーが発生しました。');
                }

                $decodeResult = json_decode($result);
                if ($decodeResult) {
                    return $decodeResult;
                }
                throw new Exception('データを取得できませんでした');

            } catch (Exeption $e) {
                echo $e->getMessage();
            }
        }

        /*
        spread sheetの取得した値を整形する
        */
        public function convertSpreadData($spreadData) {
            $dispResult = [];
            foreach ($spreadData as $row) {
                $rowStr = "";
                // 一行ごとの値を取得
                $values = $row->values;
                foreach ($values as $val) {
                    $cellVal = $val->formattedValue;
                    // セルの値をひとつずつ挿入
                    $rowStr .= "'".$cellVal."', ";
                }
                $dispResult[] = $rowStr;
            }

            return $dispResult;
        }
    }