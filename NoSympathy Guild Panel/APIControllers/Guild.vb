Imports System.Net

Public Class GuildController
    Public Function GetGuildMembers(access_token As String) As String
        Dim client As WebClient
        Dim endPoints As Uri
        Dim ret As String

        endPoints = New Uri(String.Format(APICore.Endpoints.BaseUrl + APICore.Endpoints.GuildMemberEndPoints + "?access_token={1}", APICore.Endpoints.GuildId, access_token))

        client = New WebClient()
        ret = client.DownloadString(endPoints)


        client.Dispose()


        Return ret
    End Function




End Class