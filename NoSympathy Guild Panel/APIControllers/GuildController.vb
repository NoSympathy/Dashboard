Imports System.Net
Imports Models
Imports Newtonsoft.Json

Public Class GuildController
    Inherits BaseController
    Public Function GetGuildMembers(access_token As String) As List(Of Member)
        Dim endPoints As Uri
        Dim jsonres As String
        Dim ret As List(Of Member)

        endPoints = New Uri(String.Format(APICore.Gw2Endpoints.BaseUrl + APICore.Gw2Endpoints.GuildMember, APICore.NosSettings.GuildId, APICore.NosSettings.GuildLeaderAccessToken))

        jsonres = GetApiDataByUriJson(endPoints)

        ret = JsonConvert.DeserializeObject(Of List(Of Member))(jsonres)



        Return ret
    End Function




End Class
