Imports System.Net
Imports Models
Imports Newtonsoft.Json

Public Class GuildController
    Inherits BaseController
    Public Function GetGuildMembers() As List(Of Member)

        Dim endPoints = New Uri(String.Format(APICore.Gw2Endpoints.BaseUrl + APICore.Gw2Endpoints.GuildMember, APICore.NosSettings.GuildId, APICore.NosSettings.GuildLeaderAccessToken))

        Dim jsonres = GetApiDataByUriJson(endPoints)

        Dim ret = JsonConvert.DeserializeObject(Of List(Of Member))(jsonres)



        Return ret
    End Function




End Class
