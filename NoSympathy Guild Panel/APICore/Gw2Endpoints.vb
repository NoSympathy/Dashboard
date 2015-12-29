Public Class Gw2Endpoints


    Public Const BaseUrl As String = "https://api.guildwars2.com/"



    ''' <summary>
    ''' guild end points for api
    ''' replace the {0} with guild id and {1} with guild leader api key on String.Format()
    ''' </summary>
    ''' <remarks></remarks>
    Public Const GuildMember As String = "/v2/guild/{0}/members?access_token={1}"


    Public Const World As String = "/v2/worlds"

    Public Const Account = "/v2/account"
    Public Const AccountAchievements = "/v2/account/achievements"
    Public Const AccountBank = "/v2/account/bank"
    Public Const AccountDyes = "/v2/account/dyes"
    Public Const AccountMaterials = "/v2/account/materials"
    Public Const AccountMinis = "/v2/account/minis"
    Public Const AccountSkins = "/v2/account/skins"
    Public Const AccountWallet = "/v2/account/wallet"
    Public Const Achievements = "/v2/achievements"
    Public Const AchievementsCategories = "/v2/achievements/categories"
    Public Const AchievementsDaily = "/v2/achievements/daily"
    Public Const Groups = "/v2/achievements/groups"
    Public Const Build = "/v2/build"
    Public Const Characters = "/v2/characters"
    Public Const Colors = "/v2/colors"
    Public Const Exchange = "/v2/commerce/exchange"
    Public Const ExchangeCoins = "/v2/commerce/exchange/coins"
    Public Const ExchangeGems = "/v2/commerce/exchange/gems"
    Public Const CommerceListings = "/v2/commerce/listings"
    Public Const CommercePrices = "/v2/commerce/prices"
    Public Const CommerceTransactions = "/v2/commerce/transactions"
    Public Const Continents = "/v2/continents"
    Public Const Currencies = "/v2/currencies"
    Public Const Emblem = "/v2/emblem"
    Public Const Files = "/v2/files"

    ''' <summary>
    ''' replace {0} with the id with String.Format
    ''' </summary>
    ''' <remarks></remarks>
    Public Const GuildLogs = "/v2/guild/{0}/log"

    ''' <summary>
    ''' replace {0} with the id with String.Format
    ''' </summary>
    ''' <remarks></remarks>
    Public Const GuildRanks = "/v2/guild/{0}/ranks"

    ''' <summary>
    ''' replace {0} with the id with String.Format
    ''' </summary>
    ''' <remarks></remarks>
    Public Const GuildTreasury = "/v2/guild/{0}/treasury"

    
    Public Const GuildPermissions = "/v2/guild/permissions"
    Public Const GuildUpgrades = "/v2/guild/upgrades"
    Public Const Items = "/v2/items"
    Public Const Maps = "/v2/maps"
    Public Const Materials = "/v2/materials"

    Public Const Minis = "/v2/minis"
    Public Const PvpGames = "/v2/pvp/games"
    Public Const PvpStats = "/v2/pvp/stats"
    Public Const Quaggans = "/v2/quaggans"
    Public Const Recipes = "/v2/recipes"
    Public Const RecipeSearch = "/v2/recipes/search"
    Public Const Skills = "/v2/skills"
    Public Const Skins = "/v2/skins"
    Public Const Specializations = "/v2/specializations"
    Public Const TokenInfo = "/v2/tokeninfo"
    Public Const Traits = "/v2/traits"

    Public Const Matches = "/v2/wvw/matches"
    Public Const Objectives = "/v2/wvw/objectives"

End Class
