Imports System.Net
Imports APICore
Imports Newtonsoft.Json
Imports Models


Public Class CharacterController
    Public Function GetCharacters(access_token As String) As List(Of Character)
        Dim client As WebClient
        Dim endPoints As Uri
        'Dim ret As List(Of Character)

        endPoints = New Uri(String.Format(APICore.Gw2Endpoints.BaseUrl + APICore.Gw2Endpoints.CharacterEndPoints + "access_token={0}", access_token))

        client = New WebClient()
        Dim json = client.DownloadString(endPoints)
        Dim ret = JsonConvert.DeserializeObject(Of List(Of Character))(json)

        client.Dispose()


        Return ret
    End Function




End Class
