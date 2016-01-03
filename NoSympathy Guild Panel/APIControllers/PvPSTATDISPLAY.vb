Imports System.Net
Imports APICore
Imports Newtonsoft.Json
Imports Models


Public Class PvPSTATDISPLAY
    Public Function GetPVPSTATS(access_token As String) As List(Of PvPSTATDISPLAY)
        Dim client As WebClient
        Dim endPoints As Uri


        endPoints = New Uri(String.Format(APICore.Gw2Endpoints.BaseUrl + APICore.Gw2Endpoints.PvpStats + "access_token={0}", access_token))

        client = New WebClient()
        Dim json = client.DownloadString(endPoints)
        Dim ret = JsonConvert.DeserializeObject(Of List(Of PvPSTATDISPLAY))(json)

        client.Dispose()


        Return ret
    End Function




End Class
