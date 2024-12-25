<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Interface SSP_OpenAI_Service_Interface
 * Defines methods for sentiment analysis and trade plan generation using OpenAI services.
 */
interface SSP_OpenAI_Service_Interface {
    /**
     * Analyze the sentiment of an array of news headlines.
     *
     * @param array $headlines Array of news headlines.
     *                        Each headline should be a string representing a piece of news.
     *
     * @return array {
     *     @type float $average_sentiment Overall sentiment score between -1 (negative) and 1 (positive).
     *     @type array $headline_scores   Array of [
     *         'headline' => string,      // The news headline.
     *         'score'    => float,       // Sentiment score (-1 to 1).
     *         'reasoning' => string,     // Explanation for the sentiment score.
     *         'source'   => string,      // News source (e.g., "Reuters").
     *         'date'     => string       // Date of the news item in 'Y-m-d' format.
     *     ].
     * }
     *
     * @throws InvalidArgumentException If the input array is empty or invalid.
     * @throws Exception For unexpected errors during processing.
     */
    public function analyze_sentiment(array $headlines): array;

    /**
     * Generate a trade plan based on stock data and sentiment analysis results.
     *
     * @param string $symbol     Stock symbol (e.g., "AAPL").
     * @param array  $stock_data Array containing stock-related data such as price, volatility, and trend.
     *                           Example: ['price' => float, 'volatility' => float, 'trend' => string].
     * @param float  $sentiment  Sentiment score between -1 (negative) and 1 (positive).
     * @param array  $parameters Optional parameters for trade plan customization.
     *                           Example: ['risk_tolerance' => float, 'strategy' => string].
     *
     * @return string HTML-formatted trade plan, including recommendations and actions.
     *
     * @throws InvalidArgumentException If the stock data array is incomplete or invalid.
     * @throws Exception For unexpected errors during trade plan generation.
     */
    public function generate_trade_plan(
        string $symbol,
        array $stock_data,
        float $sentiment,
        array $parameters = []
    ): string;
}
?>
