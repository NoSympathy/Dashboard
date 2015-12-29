Imports System.Net


Public Class test
    Public Function GetCharacters(access_token As String) As String
        Dim client As WebClient
        Dim Endpoints As Uri
        Dim ret As String

        Endpoints = New Uri(APICore.Endpoints.BaseUrl + APICore.Endpoints.CharacterEndPoints + "?access_token=" + access_token)


        client = New WebClient()
        ret = client.DownloadString(Endpoints)


        client.Dispose()
        Return ret
    End Function




End Class
