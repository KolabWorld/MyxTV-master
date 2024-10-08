package com.wxrk.Blocto

import com.wxrk.utils.Common


enum class EvmChain(
    val title: String,
    val symbol: String,
    val mainnetContractAddress: String,
    val testnetContractAddress: String,
    val mainnetRpcUrl: String,
    val testnetRpcUrl: String,
    val mainnetExplorerDomain: String,
    val testnetExplorerDomain: String
) {


    ETHEREUM(
        title = "Ethereum",
        symbol = "ETH",
        mainnetContractAddress = "0xfde90c9Bc193F520d119302a2dB8520D3A4408c8",
        testnetContractAddress = "0x58F385777aa6699b81f741Dd0d5B272A34C1c774",
        mainnetRpcUrl = "https://mainnet.infura.io/v3/${Common.bloctoid}",
        testnetRpcUrl = "https://rinkeby.infura.io/v3/${Common.bloctoid}",
        mainnetExplorerDomain = "etherscan.io",
        testnetExplorerDomain = "rinkeby.etherscan.io"
    ),
    BNB_CHAIN(
        title = "BNB Chain",
        symbol = "BNB",
        mainnetContractAddress = "0xfde90c9Bc193F520d119302a2dB8520D3A4408c8",
        testnetContractAddress = "0xfde90c9Bc193F520d119302a2dB8520D3A4408c8",
        mainnetRpcUrl = "https://bsc-dataseed.binance.org",
        testnetRpcUrl = "https://data-seed-prebsc-1-s1.binance.org:8545",
        mainnetExplorerDomain = "bscscan.com",
        testnetExplorerDomain = "testnet.bscscan.com"
    ),
    POLYGON(
        title = "Polygon",
        symbol = "MATIC",
        mainnetContractAddress = "0x009c403BdFaE357d82AAef2262a163287c30B739",
        testnetContractAddress = "0xfde90c9Bc193F520d119302a2dB8520D3A4408c8",
        mainnetRpcUrl = "https://polygon-mainnet.infura.io/v3/${Common.bloctoid}",
        testnetRpcUrl = "https://polygon-mumbai.infura.io/v3/${Common.bloctoid}",
        mainnetExplorerDomain = "polygonscan.com",
        testnetExplorerDomain = "mumbai.polygonscan.com"
    ),
    AVALANCHE(
        title = "Avalanche",
        symbol = "AVAX",
        mainnetContractAddress = "0xfde90c9Bc193F520d119302a2dB8520D3A4408c8",
        testnetContractAddress = "0xfde90c9Bc193F520d119302a2dB8520D3A4408c8",
        mainnetRpcUrl = "https://api.avax.network/ext/bc/C/rpc",
        testnetRpcUrl = "https://api.avax-test.network/ext/bc/C/rpc",
        mainnetExplorerDomain = "snowtrace.io",
        testnetExplorerDomain = "testnet.snowtrace.io"
    )
}
