Imports System.Net


Public Class Character
    Public Function GetCharacters(access_token As String) As String
        Dim client As WebClient
        Dim endPoints As Uri
        Dim ret As String

        endPoints = New Uri(String.Format(APICore.Endpoints.BaseUrl + APICore.Endpoints.CharacterEndPoints + "access_token={0}", access_token))

        client = New WebClient()
        ret = client.DownloadString(endPoints)


        client.Dispose()


        Return ret
    End Function




End Class
